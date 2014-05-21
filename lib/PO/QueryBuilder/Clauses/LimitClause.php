<?php

namespace PO\QueryBuilder\Clauses;

/**
 * @author Marcelo Jacobus <marcelo.jacobus@gmail.com>
 */
class LimitClause extends Base
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
            return 'LIMIT ' . implode(', ', $this->getParams());
        }
    }
}
