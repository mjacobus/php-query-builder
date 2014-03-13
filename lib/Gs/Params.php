<?php

use PO\Hash;

/**
 * @author Marcelo Jacobus <marcelo.jacobus@gmail.com>
 */
class Gs_Params extends Hash
{

    /**
     * Set the params
     *
     * @param array $params the params to be set
     * @return Gs_Params
     */
    public function setValues(array $params = array())
    {
        $this->_params = $params;
        return $this;
    }

    /**
     * Set the value
     *
     * @param string $key
     * @param mixed $value
     * @return Gs_Params
     * */
    public function setValue($key, $value)
    {
        return $this->_params[$key] = $value;
        return $this;
    }

    /**
     * Get the param by key. When key is null, return all the values
     *
     * @param string $key the key to access the param
     * @param mixed $default the default value to return case the key does not exit
     * @return mixed
     */
    public function get($key = null, $default = null)
    {
        if ($key === null) {
            return $this->toArray();
        }

        return $this->offsetGet($key, $default);
    }

    /**
     * @return array
     **/
    public function getAll()
    {
        return $this->toArray();
    }

    /**
     * Check if value is set
     * @param string key
     */
    public function keyExists($key)
    {
        return $this->offsetExists($key);
    }

}
