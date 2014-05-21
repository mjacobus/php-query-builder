<?php

namespace PO\QueryBuilder;

use PO\QueryBuilder\Clauses\SelectClause;
use PO\QueryBuilder\Clauses\FromClause;
use PO\QueryBuilder\Clauses\GroupClause;

/**
 * Helper for building SELECT SQL
 * @author Marcelo Jacobus <marcelo.jacobus@gmail.com>
 */
class Select extends ConditionalBuilderAbstract
{
    /**
     * @var PO\QueryBuilder\Clauses\SelectClause
     */
    protected $select;

    /**
     * @var PO\QueryBuilder\Clauses\FromClause
     */
    protected $from;

    /**
     * @var PO\QueryBuilder\Clauses\GroupClause
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
     * @return PO\QueryBuilder\Clauses\SelectClause
     */
    public function getSelect()
    {
        return $this->select;
    }

    /**
     * Get the FROM statement
     *
     * @return PO\QueryBuilder\Clauses\FromClause
     */
    public function getFrom()
    {
        return $this->from;
    }

    /**
     * Get the GROUP statement
     *
     * @return PO\QueryBuilder\Clauses\GroupClause
     */
    public function getGroup()
    {
        return $this->group;
    }

    /**
     * Add params to the query statement
     *
     * @param string|array $param
     * @return PO\QueryBuilder
     */
    public function select($param)
    {
        $this->getSelect()->addParams((array) $param);
        return $this;
    }

    /**
     * Get the statements in the order they should be rendered
     *
     * @return array[PO\QueryBuilder\Clauses\Clause]
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
     * @return PO\QueryBuilder
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
     * @param string $params the field and direction to order by
     * @return PO\QueryBuilder
     */
    public function groupBy($params)
    {
        $this->getGroup()->addParams((array) $params);
        return $this;
    }
}
