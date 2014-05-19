<?php

/**
 * @see Gs_QueryBuilder_ConditionalBuilderAbstract
 */
require_once 'Gs/QueryBuilder/ConditionalBuilderAbstract.php';

/**
 * @see Gs_QueryBuilder_UpdateStatement
 */
require_once 'Gs/QueryBuilder/UpdateStatement.php';

/**
 * @see Gs_QueryBuilder_SetStatement
 */
require_once 'Gs/QueryBuilder/SetStatement.php';

/**
 * Helper for building UPDATE SQL
 * @author Marcelo Jacobus <marcelo.jacobus@gmail.com>
 */
class Gs_QueryBuilder_Update extends Gs_QueryBuilder_ConditionalBuilderAbstract
{

    /**
     * @var Gs_QueryBuilder_SetStatement
     */
    protected $_set;

    /**
     * @var Gs_QueryBuilder_UpdateStatement
     */
    protected $_update;

    public function initialize()
    {
        parent::initialize();
        $this->_update = new Gs_QueryBuilder_UpdateStatement($this);
        $this->_set    = new Gs_QueryBuilder_SetStatement($this);
    }

    /**
     * Sets (overrides) the values to be set
     *
     * @param array $values the values to set
     * @return Gs_QueryBuilder_Update
     */
    public function set(array $values = array())
    {
        $this->getSet()->set($values);
        return $this;
    }

    /**
     * Adds values to be set
     *
     * @param array $values the values to set
     * @return Gs_QueryBuilder_Update
     */
    public function addSets(array $values = array())
    {
        $this->getSet()->addSets($values);
        return $this;
    }

    /**
     * Set a column and a value
     *
     * @param string $column
     * @param string $value
     * @return Gs_QueryBuilder_Update
     */
    public function addSet($column, $value)
    {
        $this->getSet()->addSet($column, $value);
        return $this;
    }

    /**
     * Set the table to update
     *
     * @param string $table
     * @return Gs_QueryBuilder_Update
     */
    public function table($table)
    {
        $this->getUpdate()->table($table);
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
            $this->getUpdate(),
            $this->getJoins(),
            $this->getSet(),
            $this->getWhere(),
            $this->getOrder(),
            $this->getLimit(),
        );
    }

    /**
     * Get the SET statement
     * @return Gs_QueryBuilder_SetStatement
     */
    public function getSet()
    {
        return $this->_set;
    }

    /**
     * Get the UPDATE statement
     * @return Gs_QueryBuilder_UpdateStatement
     */
    public function getUpdate()
    {
        return $this->_update;
    }
}
