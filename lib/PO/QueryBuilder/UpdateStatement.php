<?php

/**
 * @see Gs_QueryBuilder_Statement
 */
require_once 'Gs/QueryBuilder/Statement.php';

/**
 * @author Marcelo Jacobus <marcelo.jacobus@gmail.com>
 */
class Gs_QueryBuilder_UpdateStatement extends Gs_QueryBuilder_Statement
{
    /**
     * Informs that the query is not empty
     *
     * @return boolean
     */
    public function isEmpty()
    {
        return false;
    }

    /**
     * Return the resulting query
     * @return string
     */
    public function toSql()
    {
        return 'UPDATE ' . implode(', ', $this->getParams());
    }

    /**
     * Sets the table to update
     * @return Gs_QueryBuilder_UpdateStatement
     */
    public function table($tableName)
    {
        $this->setParams(array($tableName));
        return $this;
    }

}
