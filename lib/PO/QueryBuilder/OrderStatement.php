<?php

namespace PO\QueryBuilder;

/**
 * @author Marcelo Jacobus <marcelo.jacobus@gmail.com>
 */
class OrderStatement extends Statement
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
