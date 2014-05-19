<?php

/**
 * @see Gs_QueryBuilder
 */
require_once 'Gs/QueryBuilder.php';

/**
 * @author Marcelo Jacobus <marcelo.jacobus@gmail.com>
 */
class Gs_QueryBuilder_Statement
{
    /**
     * @param Gs_QueryBuilder $builder
     */
    protected $_builder;

    /**
     * @param array $_params
     */
    protected $_params = array();

    /**
     * @param Gs_QueryBuilder_Abstract $builder
     */
    public function __construct(Gs_QueryBuilder_Abstract $builder)
    {
        $this->_builder = $builder;
    }

    /**
     * Get the query builder
     *
     * @return Gs_QueryBuilder
     */
    public function getBuilder()
    {
        return $this->_builder;
    }

    /**
     * Add one param to the existing collection of params
     *
     * @param mixed $param
     * @return Gs_QueryBuilder_Statement
     */
    public function addParam($param)
    {
        $this->_params[] = $param;
        return $this;
    }

    /**
     * Set the params. Remove old ones.
     *
     * @param array $params
     * @return Gs_QueryBuilder_Statement
     */
    public function setParams(array $params)
    {
        return $this->reset()->addParams($params);
    }


    /**
     * @param mixed $param
     *
     * @return array
     */
    public function getParams()
    {
        return $this->_params;
    }

    /**
     * Add a collection of params
     *
     * @param array $params
     * @return Gs_QueryBuilder_Statement
     */
    public function addParams(array $params)
    {
        foreach($params as $param) {
            $this->addParam($param);
        }

        return $this;
    }

    /**
     * @return Gs_QueryBuilder_Statement
     */
    public function reset()
    {
        $this->_params = array();
        return $this;
    }

    /**
     * Informs if the query is empty
     *
     * @return boolean
     */
    public function isEmpty()
    {
        return count($this->getParams()) === 0;
    }

    /**
     * Return the sql part of the statement
     *
     * @return string
     */
    public function toSql()
    {
        return '';
    }

    /**
     * Object to String. Alias to __toString()
     * @return string
     */
    public function toString()
    {
        return $this->toSql();
    }

    /**
     * Object to String
     * @return string
     */
    public function __toString()
    {
        return $this->toString();
    }
}
