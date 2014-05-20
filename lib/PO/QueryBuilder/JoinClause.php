<?php

namespace PO\QueryBuilder;

/**
 * @author Marcelo Jacobus <marcelo.jacobus@gmail.com>
 */
class JoinClause extends Statement
{

    /**
     * Inner Joins a table
     *
     * @param string $join the table to join
     * @param string $on the condtition to join
     * @return PO\QueryBuilder\JoinClause
     */
    public function innerJoin($join, $on = null)
    {
        return $this->addJoin('INNER', $join, $on);
    }

    /**
     * Left Joins a table
     *
     * @param string $join the table to join
     * @param string $on the condtition to join
     * @return PO\QueryBuilder\JoinClause
     */
    public function leftJoin($join, $on = null)
    {
        return $this->addJoin('LEFT', $join, $on);
    }

    /**
     * Return the resulting query
     * @return string
     */
    public function toSql()
    {
        if ($this->isEmpty()) {
            return '';
        } else {
            return implode(' ', $this->getParams());
        }
    }

    /**
     * Joins a table
     *
     * @param string $type the type of join (INNER, LEFT)
     * @param string $join the table to join
     * @param string $on the condtition to join
     * @return PO\QueryBuilder\JoinClause
     */
    private function addJoin($type, $join, $on = null)
    {
        $join = "$type JOIN $join";

        if ($on !== null) {
            $join .= " ON $on";
        }

        $this->addParam($join);
        return $this;
    }
}
