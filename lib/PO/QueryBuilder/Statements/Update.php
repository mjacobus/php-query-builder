<?php

namespace PO\QueryBuilder\Statements;

use PO\QueryBuilder\Clauses\Clause;
use PO\QueryBuilder\Clauses\UpdateClause;
use PO\QueryBuilder\Clauses\SetClause;

/**
 * Helper for building UPDATE SQL
 * @author Marcelo Jacobus <marcelo.jacobus@gmail.com>
 */
class Update extends ConditionalStatement
{

    /**
     * @var SetClause
     */
    protected $set;

    /**
     * @var UpdateClause
     */
    protected $update;

    public function initialize()
    {
        parent::initialize();
        $this->update = new UpdateClause($this);
        $this->set    = new SetClause($this);
    }

    /**
     * Sets (overrides) the values to be set
     *
     * @param array $values the values to set
     * @return self
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
     * @return self
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
     * @return self
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
     * @return self
     */
    public function table($table)
    {
        $this->getUpdate()->table($table);
        return $this;
    }

    /**
     * Get the statements in the order they should be rendered
     *
     * @return array[Clause]
     */
    public function getClauses()
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
     * @return SetClause
     */
    public function getSet()
    {
        return $this->set;
    }

    /**
     * Get the UPDATE statement
     * @return UpdateClause
     */
    public function getUpdate()
    {
        return $this->update;
    }
}
