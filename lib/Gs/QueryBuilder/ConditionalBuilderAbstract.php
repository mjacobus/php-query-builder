<?php

/**
 * @see Gs_QueryBuilder_Abstract
 */
require_once 'Gs/QueryBuilder/Abstract.php';

/**
 * @see Gs_QueryBuilder_JoinStatement
 */
require_once 'Gs/QueryBuilder/JoinStatement.php';

/**
 * @see Gs_QueryBuilder_WhereStatement
 */
require_once 'Gs/QueryBuilder/WhereStatement.php';

/**
 * @see Gs_QueryBuilder_OrderStatement
 */
require_once 'Gs/QueryBuilder/OrderStatement.php';

/**
 * @see Gs_QueryBuilder_LimitStatement
 */
require_once 'Gs/QueryBuilder/LimitStatement.php';

/**
 * Helper for building SELECT SQL
 * @author Marcelo Jacobus <marcelo.jacobus@gmail.com>
 */
class Gs_QueryBuilder_ConditionalBuilderAbstract extends Gs_QueryBuilder_Abstract
{

    /**
     * @var Gs_QueryBuilder_WhereStatement
     */
    protected $_where;

    /**
     * @var Gs_QueryBuilder_OrderStatement
     */
    protected $_order;

    /**
     * @var Gs_QueryBuilder_JoinStatement
     */
    protected $_joins;

    /**
     * @var Gs_QueryBuilder_LimitStatement
     */
    protected $_limit;

    /**
     * Constructor
     * Set up statements
     */
    public function initialize()
    {
        $this->_where  = new Gs_QueryBuilder_WhereStatement($this);
        $this->_order  = new Gs_QueryBuilder_OrderStatement($this);
        $this->_limit  = new Gs_QueryBuilder_LimitStatement($this);
        $this->_joins  = new Gs_QueryBuilder_JoinStatement($this);
    }

    /**
     * Get the JOINS statements
     *
     * @return Gs_QueryBuilder_JoinStatement
     */
    public function getJoins()
    {
        return $this->_joins;
    }

    /**
     * Get the WHERE statement
     *
     * @return Gs_QueryBuilder_WhereStatement
     */
    public function getWhere()
    {
        return $this->_where;
    }

    /**
     * Get the ORDER statement
     *
     * @return Gs_QueryBuilder_OrderStatement
     */
    public function getOrder()
    {
        return $this->_order;
    }

    /**
     * Get the LIMIT statement
     *
     * @return Gs_QueryBuilder_OrderStatement
     */
    public function getLimit()
    {
        return $this->_limit;
    }

    /**
     * Get the statements in the order they should be rendered
     *
     * @return array[Gs_QueryBuilder_Statement]
     */
    public function getStatements()
    {
        return array(
            $this->getJoins(),
            $this->getWhere(),
            $this->getOrder(),
            $this->getLimit(),
        );
    }

    /**
     * Adds INNER JOIN to the query
     *
     * @param string $join
     * @param string $on
     * @return Gs_QueryBuilder
     */
    public function innerJoin($join, $on = null)
    {
        $this->getJoins()->innerJoin($join, $on);
        return $this;
    }

    /**
     * Adds LEFT JOIN to the query
     *
     * @param string $join
     * @param string $on
     * @return Gs_QueryBuilder
     */
    public function leftJoin($join, $on = null)
    {
        $this->getJoins()->leftJoin($join, $on);
        return $this;
    }

    /**
     * Add conditions
     * I.E.
     *
     * $this->where('a = 1')
     *       ->where('a', 'b')
     *       ->where('a', 'x', '!=')
     *       ->where(array(
     *           'foo' => 'bar',
     *           'foobar' => 'foo'
     *       ));
     *
     * @param array|string $conditions
     * @param string $value
     * @param string $operator
     * @return Gs_QueryBuilder
     */
    public function where($conditions, $value = null, $operator = '=')
    {
        if (is_array($conditions)) {
            $this->getWhere()->addConditions($conditions);
        } else {
            $this->getWhere()->addCondition($conditions, $value, $operator);
        }

        return $this;
    }

    /**
     * Add order by
     * I.E.
     *
     * $this->orderBy('foo')->orderBy('bar DESC')->orderBy(array('foobar'));
     *
     * @param string $params the field and direction to order by
     * @return Gs_QueryBuilder
     */
    public function orderBy($params)
    {
        $this->getOrder()->addParams((array) $params);
        return $this;
    }

    /**
     * Add limit
     * I.E.
     *
     * @param int $limit
     * @param int $offset
     * @return Gs_QueryBuilder
     */
    public function limit($limit, $offset = null)
    {
        if ($offset) {
            $this->getLimit()->setParams(array($limit, $offset));
        } else {
            $this->getLimit()->setParams(array($limit));
        }

        return $this;
    }

}
