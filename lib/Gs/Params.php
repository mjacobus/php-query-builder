<?php

/**
 * @author Marcelo Jacobus <marcelo.jacobus@gmail.com>
 */
class Gs_Params implements Iterator, ArrayAccess
{

    /**
     * @var array
     **/
    protected $_params = array();

    /**
     * @param array $params Key => Value array
     */
    public function __construct(array $params = array())
    {
        $this->setValues($params);
    }

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
            return $this->getAll();
        }

        if ($this->keyExists($key)) {
            return $this->_params[$key];
        }

        return $default;
    }

    /**
     * @return array
     **/
    public function getAll()
    {
        return $this->_params;
    }


    /**
     * Check if value is set
     * @param string key
     */
    public function keyExists($key)
    {
        return array_key_exists($key, $this->_params);
    }

    /**
     * Iterator implementation
     */
    public function key()
    {
        return key($this->_params);
    }

    /**
     * Iterator implementation
     */
    public function rewind()
    {
        return reset($this->_params);
    }

    /**
     * Iterator implementation
     */
    public function next()
    {
        return next($this->_params);
    }

    /**
     * Iterator implementation
     */
    public function current()
    {
        return current($this->_params);
    }

    /**
     * Iterator implementation
     */
    public function valid()
    {
        $key = key($this->_params);
        return ($key !== null && $key !== false);
    }

    /**
     * ArrayAccess implementation
     */
    public function offsetGet($key)
    {
        return $this->get($key);
    }

    /**
     * ArrayAccess implementation
     */
    public function offsetSet($key, $value)
    {
        return $this->setValue($key, $value);
    }

    /**
     * ArrayAccess implementation
     */
    public function offsetExists($key)
    {
        return $this->keyExists($key);
    }

    /**
     * ArrayAccess implementation
     */
    public function offsetUnset($key)
    {
        if ($this->offsetExists($key)) {
            unset($this->_params[$key]);
        }

        return $this;

    }

}
