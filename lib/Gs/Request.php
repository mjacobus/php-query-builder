<?php

/**
 * @see Gs_Params
 */
require_once 'Gs/Params.php';

/**
 * @author Marcelo Jacobus <marcelo.jacobus@gmail.com>
 */
class Gs_Request
{

    /**
     * @var Gs_Params
     */
    protected $_server;

    /**
     * @var Gs_Params
     */
    protected $_post;

    /**
     * @var Gs_Params
     */
    protected $_get;

    /**
     * Represents the request
     *
     * @param array $server the $_SERVER variable
     * @param array $post the $_POST variable
     * @param array $get teh $_GET variable
     */
    public function __construct(array $server = array(), $post = array(), array $get = array())
    {
        $this->_server = new Gs_Params($server);
        $this->_post   = new Gs_Params($post);
        $this->_get    = new Gs_Params($get);
    }

    /**
     * Get the server var or vars
     * If no key is given all the array is returned
     *
     * @param string $key the key to the server var
     * @param mixed $default the value to return if key is no set
     * @return mixed
     */
    public function getServer($key = null, $default = null)
    {
        return $this->_server->get($key, $default);
    }

    /**
     * Get the post var or vars
     * If no key is given all the array is returned
     *
     * @param string $key the key to the post var
     * @param mixed $default the value to return if key is no set
     * @return mixed
     */
    public function getPost($key = null, $default = null)
    {
        return $this->_post->get($key, $default);
    }

    /**
     * Get the get var or vars
     * If no key is given all the array is returned
     *
     * @param string $key the key to the get var
     * @param mixed $default the value to return if key is no set
     * @return mixed
     */
    public function getGet($key = null, $default = null)
    {
        return $this->_get->get($key, $default);
    }

    /**
     * Get either the post or the get param by the given key.
     * Return $default if none is found
     *
     * @param string $key the key to the Post or Get param
     * @param mixed $default the value to return if key is no set
     */
    public function getParam($key, $default = null)
    {
        if ($this->_post->offsetExists($key)) {
            return $this->getPost($key);
        } else if ($this->_get->offsetExists($key)) {
            return $this->getGet($key);
        }

        return $default;
    }

    /**
     * Get Get params merged with Post Params. Post params have higher priority
     * @return array
     */
    public function getParams()
    {
        $get  = $this->_get->get();
        $post = $this->_post->get();

        return array_merge($get, $post);
    }


    /**
     * Check if request is POST
     * @return boolean
     */
    public function isPost()
    {
        return $this->getMethod() === 'POST';
    }

    /**
     * Check if request is AJAX
     * @return boolean
     */
    public function isAjax()
    {
        return $this->getServer('X_REQUESTED_WITH') === 'XMLHttpRequest';
    }

    /**
     * Get the request method
     * @return string
     */
    public function getMethod()
    {
       return $this->getServer('REQUEST_METHOD');
    }

}
