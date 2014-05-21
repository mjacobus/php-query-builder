<?php

namespace PO\QueryBuilder\Clauses;

/**
 * @author Marcelo Jacobus <marcelo.jacobus@gmail.com>
 */
class UpdateClause extends Base
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
     * @return PO\QueryBuilder\Clauses\UpdateClause
     */
    public function table($tableName)
    {
        $this->setParams(array($tableName));
        return $this;
    }
}
