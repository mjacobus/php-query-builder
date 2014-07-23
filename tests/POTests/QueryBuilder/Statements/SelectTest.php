<?php

namespace POTests\QueryBuilder;

use PHPUnit_Framework_TestCase;
use PO\QueryBuilder;
use PO\QueryBuilder\Statements\Select;
use PO\QueryBuilder\Helper;

class SelectTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var Select
     */
    protected $object;

    public function setUp()
    {
        $this->object = new Select();
        $this->object->getHelper()->setDoubleQuoted(true);
    }

    public function testGetSelect()
    {
        $this->assertInstanceOf(
            'PO\QueryBuilder\Clauses\SelectClause',
            $this->object->getSelect()
        );
    }

    public function testGetFrom()
    {
        $this->assertInstanceOf(
            'PO\QueryBuilder\Clauses\FromClause',
            $this->object->getFrom()
        );
    }

    public function testGetWhere()
    {
        $this->assertInstanceOf(
            'PO\QueryBuilder\Clauses\WhereClause',
            $this->object->getWhere()
        );
    }

    public function testGetOrder()
    {
        $this->assertInstanceOf(
            'PO\QueryBuilder\Clauses\OrderClause',
            $this->object->getOrder()
        );
    }

    public function testGetLimit()
    {
        $this->assertInstanceOf(
            'PO\QueryBuilder\Clauses\LimitClause',
            $this->object->getLimit()
        );
    }

    public function testGetJoins()
    {
        $this->assertInstanceOf(
            'PO\QueryBuilder\Clauses\JoinClause',
            $this->object->getJoins()
        );
    }

    public function testGetGroup()
    {
        $this->assertInstanceOf(
            'PO\QueryBuilder\Clauses\GroupClause',
            $this->object->getGroup()
        );
    }

    public function testGetHelper()
    {
        $this->assertInstanceOf(
            'PO\QueryBuilder\Helper',
            $this->object->getHelper()
        );
    }

    public function testItInitializesWithTheCorrectHelper()
    {
        $helper = new Helper();
        $options = array('helper' => $helper);
        $object = new QueryBuilder($options);
        $this->assertSame($helper, $object->getHelper());
    }

    public function testItCanConvertQueryToString()
    {
        $sql = 'SELECT a';
        $this->object->select('a');
        $this->assertEquals($sql, $this->object->toSql());

        $sql .= ' FROM table';
        $this->object->from('table');
        $this->assertEquals($sql, $this->object->toSql());

        $sql .= ' INNER JOIN table2';
        $this->object->innerJoin('table2');
        $this->assertEquals($sql, $this->object->toSql());

        $sql .= ' WHERE a = "b" AND b = 1';
        $this->object->where('a', 'b')->where(array('b' => 1));
        $this->assertEquals($sql, $this->object->toSql());

        $sql .= ' GROUP BY group1, group2';
        $this->object->groupBy(array('group1'))->groupBy('group2');
        $this->assertEquals($sql, $this->object->toSql());

        $sql .= ' ORDER BY foo, bar DESC';
        $this->object->orderBy(array('foo', 'bar DESC'));
        $this->assertEquals($sql, $this->object->toSql());

        $sql .= ' LIMIT 10';
        $this->object->limit(10);
        $this->assertEquals($sql, $this->object->toSql());

        $sql .= ', 3';
        $this->object->limit(10, 3);
        $this->assertEquals($sql, $this->object->toSql());
    }

    public function testItGetSqlReplacingThePlaceHolders()
    {
        $this->object->from('table')->where(array(
            'size > :min',
            'size < :max',
            'count != :min',
            'name = :name',
        ));

        $params = array(
            'min' => 10,
            'max' => 20,
            'name' => 'foo'
        );

        $sql = 'SELECT * FROM table WHERE size > 10 AND size < 20 AND count != 10 AND name = "foo"';

        $this->assertEquals($sql, $this->object->toSql($params));
    }

    public function testItCallsToSqlWhenConvertingToString()
    {
        $this->assertEquals($this->object->toSql(), (string) $this->object);
    }
}
