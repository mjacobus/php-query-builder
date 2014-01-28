<?php

/**
 * @see Gs_QueryBuilder_Abstract
 */
require_once 'Gs/QueryBuilder/Abstract.php';

/**
 * @see Gs_QueryBuilder_SelectStatement
 */
require_once 'Gs/QueryBuilder/SelectStatement.php';

/**
 * @see Gs_QueryBuilder_FromStatement
 */
require_once 'Gs/QueryBuilder/FromStatement.php';

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
 * @see Gs_QueryBuilder_GroupStatement
 */
require_once 'Gs/QueryBuilder/GroupStatement.php';

/**
 * Helper for building SELECT SQL
 * @author Marcelo Jacobus <marcelo.jacobus@gmail.com>
 */
class Gs_QueryBuilder_Select extends Gs_QueryBuilder_Abstract
{
    /**
     * @var Gs_QueryBuilder_SelectStatement
     */
    protected $_select;

    /**
     * @var Gs_QueryBuilder_FromStatement
     */
    protected $_from;

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
     * @var Gs_QueryBuilder_GroupStatement
     */
    protected $_group;

    /**
     * Constructor
     * Set up statements
     */
    public function initialize()
    {
        $this->_select = new Gs_QueryBuilder_SelectStatement($this);
        $this->_from   = new Gs_QueryBuilder_FromStatement($this);
        $this->_where  = new Gs_QueryBuilder_WhereStatement($this);
        $this->_order  = new Gs_QueryBuilder_OrderStatement($this);
        $this->_joins  = new Gs_QueryBuilder_JoinStatement($this);
        $this->_group  = new Gs_QueryBuilder_GroupStatement($this);
    }

    /**
     * Get the SELECT statement
     *
     * @return Gs_QueryBuilder_SelectStatement
     */
    public function getSelect()
    {
        return $this->_select;
    }

    /**
     * Get the FROM statement
     *
     * @return Gs_QueryBuilder_FromStatement
     */
    public function getFrom()
    {
        return $this->_from;
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
     * Get the ORDER statement
     *
     * @return Gs_QueryBuilder_GroupStatement
     */
    public function getGroup()
    {
        return $this->_group;
    }

    /**
     * Set the helper
     *
     * @param Gs_QueryBuilder_Helper $helper
     * @return Gs_QueryBuilder
     */
    public function setHelper(Gs_QueryBuilder_Helper $helper)
    {
        $this->_helper = $helper;
        return $this;
    }

    /**
     * Get the helper
     *
     * @return Gs_QueryBuilder_Helper
     */
    public function getHelper()
    {
        return $this->_helper;
    }

    /**
     * Add params to the query statement
     *
     * @param string|array $param
     * @return Gs_QueryBuilder
     */
    public function select($param)
    {
        $this->getSelect()->addParams((array) $param);
        return $this;
    }

    /**
     * Get the statements in the order they should be rendered
     *
     * @return array[Gs_QueryBuilder_Statement]
     */
    public function getStatements()
    {
        return array(
            $this->getSelect(),
            $this->getFrom(),
            $this->getJoins(),
            $this->getWhere(),
            $this->getGroup(),
            $this->getOrder(),
        );
    }

    /**
     * Set the from statement
     *
     * @param array|string
     * @return Gs_QueryBuilder
     */
    public function from($params)
    {
        $this->getFrom()->setParams((array) $params);
        return $this;
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
     * Add group by
     * I.E.
     *
     * $this->groupBy('foo')->groupBy('bar DESC')->groupBy(array('foobar'));
     *
     * @param string $params the field and direction to order by
     * @return Gs_QueryBuilder
     */
    public function groupBy($params)
    {
        $this->getGroup()->addParams((array) $params);
        return $this;
    }

}
