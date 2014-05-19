<?php

/**
 * @see Gs_QueryBuilder_Statement
 */
require_once 'Gs/QueryBuilder/Statement.php';

/**
 * @author Marcelo Jacobus <marcelo.jacobus@gmail.com>
 */
class Gs_QueryBuilder_OrderStatement extends Gs_QueryBuilder_Statement
{
    /**
     * Return the resulting query
     * @return string
     */
    public function toSql()
    {
        if ($this->isEmpty()) {
            return '';
        } else {
            return 'ORDER BY ' . implode(', ', $this->getParams());
        }
    }

}
