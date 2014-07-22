<?php

namespace PO\QueryBuilder\Clauses;

/**
 * @author Marcelo Jacobus <marcelo.jacobus@gmail.com>
 */
class ReturningClause extends Base
{

    /**
     * Return the resulting query
     * @return string
     */
    public function toSql()
    {
        if (!$this->isEmpty()) {
            return 'RETURNING ' . implode(', ', $this->getParams());
        }

        return '';
    }
}
