<?php

/**
 * @see Gs_QueryBuilder_Statement
 */
require_once 'Gs/QueryBuilder/Statement.php';

/**
 * @author Marcelo Jacobus <marcelo.jacobus@gmail.com>
 */
class Gs_QueryBuilder_SelectStatement extends Gs_QueryBuilder_Statement
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
        if (0 === count($this->getParams())) {
            return 'SELECT *';
        } else {
            return 'SELECT ' . implode(', ', $this->getParams());
        }
    }

}
