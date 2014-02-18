<?php

/**
 * @see Gs_QueryBuilder_SelectStatement
 */
require_once 'Gs/QueryBuilder/SelectStatement.php';

/**
 * @see Gs_QueryBuilder_FromStatement
 */
require_once 'Gs/QueryBuilder/FromStatement.php';

/**
 * @see Gs_QueryBuilder_GroupStatement
 */
require_once 'Gs/QueryBuilder/GroupStatement.php';

/**
 * @see Gs_QueryBuilder_ConditionalBuilderAbstract
 */
require_once 'Gs/QueryBuilder/ConditionalBuilderAbstract.php';

/**
 * Helper for building SELECT SQL
 * @author Marcelo Jacobus <marcelo.jacobus@gmail.com>
 */
class Gs_QueryBuilder_Select extends Gs_QueryBuilder_ConditionalBuilderAbstract
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
     * @var Gs_QueryBuilder_GroupStatement
     */
    protected $_group;

    /**
     * Constructor
     * Set up statements
     */
    public function initialize()
    {
        parent::initialize();
        $this->_select = new Gs_QueryBuilder_SelectStatement($this);
        $this->_from   = new Gs_QueryBuilder_FromStatement($this);
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
     * Get the GROUP statement
     *
     * @return Gs_QueryBuilder_GroupStatement
     */
    public function getGroup()
    {
        return $this->_group;
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
            $this->getLimit(),
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
