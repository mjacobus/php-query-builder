<?php

namespace PO\QueryBuilder\Statements;

use PO\QueryBuilder\Clauses\WhereClause;
use PO\QueryBuilder\Clauses\OrderClause;
use PO\QueryBuilder\Clauses\LimitClause;
use PO\QueryBuilder\Clauses\JoinClause;

/**
 * Helper for building SELECT SQL
 * @author Marcelo Jacobus <marcelo.jacobus@gmail.com>
 */
abstract class ConditionalStatement extends Base
{

    /**
     * @var WhereClause
     */
    protected $where;

    /**
     * @var OrderClause
     */
    protected $order;

    /**
     * @var JoinClause
     */
    protected $joins;

    /**
     * @var LimitClause
     */
    protected $limit;

    /**
     * Constructor
     * Set up statements
     */
    public function initialize()
    {
        $this->where  = new WhereClause($this);
        $this->order  = new OrderClause($this);
        $this->limit  = new LimitClause($this);
        $this->joins  = new JoinClause($this);
    }

    /**
     * Get the JOINS statements
     *
     * @return JoinClause
     */
    public function getJoins()
    {
        return $this->joins;
    }

    /**
     * Get the WHERE statement
     *
     * @return WhereClause
     */
    public function getWhere()
    {
        return $this->where;
    }

    /**
     * Get the ORDER statement
     *
     * @return OrderClause
     */
    public function getOrder()
    {
        return $this->order;
    }

    /**
     * Get the LIMIT statement
     *
     * @return OrderClause
     */
    public function getLimit()
    {
        return $this->limit;
    }

    /**
     * Get the statements in the order they should be rendered
     *
     * @return array[Clause]
     */
    public function getClauses()
    {
        return array();
    }

    /**
     * Adds INNER JOIN to the query
     *
     * @param  string $join
     * @param  string $on
     * @return self
     */
    public function innerJoin($join, $on = null)
    {
        $this->getJoins()->innerJoin($join, $on);

        return $this;
    }

    /**
     * Adds LEFT JOIN to the query
     *
     * @param  string $join
     * @param  string $on
     * @return self
     */
    public function leftJoin($join, $on = null)
    {
        $this->getJoins()->leftJoin($join, $on);

        return $this;
    }

    /**
     * Add conditions
     * I.E.
     *
     * $this->where('a = 1')
     *       ->where('a', 'b')
     *       ->where('a', 'x', '!=')
     *       ->where(array(
     *           'foo' => 'bar',
     *           'foobar' => 'foo'
     *       ));
     *
     * @param  array|string    $conditions
     * @param  string          $value
     * @param  string          $operator
     * @return PO\QueryBuilder
     */
    public function where($conditions, $value = null, $operator = '=')
    {
        if (is_array($conditions)) {
            $this->getWhere()->addConditions($conditions);
        } else {
            $this->getWhere()->addCondition($conditions, $value, $operator);
        }

        return $this;
    }

    /**
     * Add order by
     * I.E.
     *
     * $this->orderBy('foo')->orderBy('bar DESC')->orderBy(array('foobar'));
     *
     * @param  string $params the field and direction to order by
     * @return self
     */
    public function orderBy($params)
    {
        $this->getOrder()->addParams((array) $params);

        return $this;
    }

    /**
     * Add limit
     * I.E.
     *
     * @param  int  $limit
     * @param  int  $offset
     * @return self
     */
    public function limit($limit, $offset = null)
    {
        if ($offset) {
            $this->getLimit()->setParams(array($limit, $offset));
        } else {
            $this->getLimit()->setParams(array($limit));
        }

        return $this;
    }
}
