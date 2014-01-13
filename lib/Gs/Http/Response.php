<?php

class Gs_Http_Response
{

    /**
     * @var string the body content
     */
    protected $_body = '';

    /**
     * Get the body content
     * @return string
     */
    public function getBody()
    {
        return $this->_body;
    }

    /**
     * set the body content
     * @param string $body
     * @return Gs_Http_Body
     */
    public function setBody($body)
    {
        $this->_body = $body;
        return $this;
    }

    /**
     * Append content to the body
     * @param string $content
     * @return Gs_Http_Body
     */
    public function append($content)
    {
        $this->_body .= $content;
        return $this;
    }

}
