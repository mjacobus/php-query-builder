<?php

namespace PO\QueryBuilder\Statements;

use PO\QueryBuilder\Helper;
use PO\QueryBuilder\Clauses\Clause;
use PO\QueryBuilder\Clauses\SelectClause;
use PO\QueryBuilder\Clauses\FromClause;
use PO\QueryBuilder\Clauses\GroupClause;

/**
 * Helper for building SELECT SQL
 * @author Marcelo Jacobus <marcelo.jacobus@gmail.com>
 */
class Select extends ConditionalStatement
{
    /**
     * @var SelectClause
     */
    protected $select;

    /**
     * @var FromClause
     */
    protected $from;

    /**
     * @var GroupClause
     */
    protected $group;

    /**
     * Constructor
     * Set up statements
     */
    public function initialize()
    {
        parent::initialize();
        $this->select = new SelectClause($this);
        $this->from   = new FromClause($this);
        $this->group  = new GroupClause($this);
    }

    /**
     * Get the SELECT statement
     *
     * @return SelectClause
     */
    public function getSelect()
    {
        return $this->select;
    }

    /**
     * Get the FROM statement
     *
     * @return FromClause
     */
    public function getFrom()
    {
        return $this->from;
    }

    /**
     * Get the GROUP statement
     *
     * @return GroupClause
     */
    public function getGroup()
    {
        return $this->group;
    }

    /**
     * Add params to the query statement
     *
     * @param  string|array $param
     * @return self
     */
    public function select($param)
    {
        $this->getSelect()->addParams((array) $param);

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
            $this->getSelect(),
            $this->getFrom(),
            $this->getJoins(),
            $this->getWhere(),
            $this->getGroup(),
            $this->getOrder(),
            $this->getLimit(),
        );
    }

    /**
     * Set the from statement
     *
     * @param array|string
     * @return self
     */
    public function from($params)
    {
        $this->getFrom()->setParams((array) $params);

        return $this;
    }

    /**
     * Add group by
     * I.E.
     *
     * $this->groupBy('foo')->groupBy('bar DESC')->groupBy(array('foobar'));
     *
     * @param  string $params the field and direction to order by
     * @return self
     */
    public function groupBy($params)
    {
        $this->getGroup()->addParams((array) $params);

        return $this;
    }
}
