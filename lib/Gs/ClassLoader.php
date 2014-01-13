<?php

class Gs_ClassLoader
{

    /**
     * Attempts to load class
     *
     * @param string $class
     * @return boolean
     */
    public function load($class)
    {
        $file = $this->fileName($class);

        $paths = explode(PATH_SEPARATOR, get_include_path());

        foreach($paths as $path) {
            if (file_exists($path . '/' . $file)) {
                require_once $file;
                return true;
            }
        }

        return false;
    }

    /**
     * Get the name of the class to load
     * @param string $class the class name to load
     * @return string the relative file path
     */
    public function fileName($class)
    {
        return str_replace('_', '/', $class) . '.php';
    }

    /**
     * Register this class as autoloader
     *
     * @param boolean $prepend should prepend autoloader?
     * @param boolean $throwExceptions should throw exceptions if class is not found?
     */
    public function register($prepend = true, $throwExceptions = false)
    {
        spl_autoload_register(array($this, 'load'), $throwExceptions, $prepend);
    }

}
