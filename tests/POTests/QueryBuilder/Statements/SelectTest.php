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
        $this->assertInstanceOf('PO\QueryBuilder\Clauses\SelectClause', $this->object->getSelect());
    }

    public function testGetFrom()
    {
        $this->assertInstanceOf('PO\QueryBuilder\Clauses\FromClause', $this->object->getFrom());
    }

    public function testGetWhere()
    {
        $this->assertInstanceOf('PO\QueryBuilder\Clauses\WhereClause', $this->object->getWhere());
    }

    public function testGetOrder()
    {
        $this->assertInstanceOf('PO\QueryBuilder\Clauses\OrderClause', $this->object->getOrder());
    }

    public function testGetLimit()
    {
        $this->assertInstanceOf('PO\QueryBuilder\Clauses\LimitClause', $this->object->getLimit());
    }

    public function testGetJoins()
    {
        $this->assertInstanceOf('PO\QueryBuilder\Clauses\JoinClause', $this->object->getJoins());
    }

    public function testGetGroup()
    {
        $this->assertInstanceOf('PO\QueryBuilder\Clauses\GroupClause', $this->object->getGroup());
    }

    public function testGetHelper()
    {
        $this->assertInstanceOf('PO\QueryBuilder\Helper', $this->object->getHelper());
    }

    public function testItInitializesWithTheCorrectHelper()
    {
        $helper = new Helper();
        $options = array('helper' => $helper);
        $object = new QueryBuilder($options);
        $this->assertSame($helper, $object->getHelper());
    }

    public function testItCanSetAddFieldsToTheSelectClauseAsStringAndReturnBuilder()
    {
        $object = $this->object->select('field')->select(array('one', 'two'));
        $this->assertSame($this->object, $object);
        $this->assertEquals(array('field', 'one', 'two'), $this->object->getSelect()->getParams());
    }

    public function testCanSetFromAsStringAndReturnBuilder()
    {
        $object = $this->object->from('table');
        $this->assertSame($this->object, $object);
        $this->assertEquals(array('table'), $this->object->getFrom()->getParams());

        $object = $this->object->from(array('table1', 'table2'));
        $this->assertEquals(array('table1', 'table2'), $this->object->getFrom()->getParams());
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

    public function testItAddsInnerJoin()
    {
        $this->object->from('table')->innerJoin('t1')->innerJoin('t2', 't1.id = t2.t1_id');
        $sql = 'INNER JOIN t1 INNER JOIN t2 ON t1.id = t2.t1_id';
        $this->assertEquals($sql, $this->object->getJoins()->toSql());
    }

    public function testItAddsLeftJoin()
    {
        $this->object->from('table')->leftJoin('t1')->leftJoin('t3', 't1.id = t3.t1_id');
        $sql = 'LEFT JOIN t1 LEFT JOIN t3 ON t1.id = t3.t1_id';
        $this->assertEquals($sql, $this->object->getJoins()->toSql());
    }

    public function testItCallsToSqlWhenConvertingToString()
    {
        $this->assertEquals($this->object->toSql(), (string) $this->object);
    }

    public function testItProvidesInterfaceForAddingConditions()
    {
        $this->object->where('a = 1')
            ->where('a', 'b')
            ->where('a', 'x', '!=')
            ->where(array(
                'bar' => 'foo',
                'foobar' => 'foo'
            ));

        $expectedParams = array(
            'a = 1',
            'a = "b"',
            'a != "x"',
            'bar = "foo"',
            'foobar = "foo"',
        );

        $this->assertEquals($expectedParams, $this->object->getWhere()->getParams());
    }

    public function testItProvidesInterfaceForAddingOrder()
    {
        $this->object->orderBy('a')->orderBy(array('b', 'c'));

        $expectedParams = array( 'a', 'b', 'c');

        $this->assertEquals($expectedParams, $this->object->getOrder()->getParams());
    }

    public function testItProvidesInterfaceForAddingGroup()
    {
        $this->object->groupBy('a')->groupBy(array('b', 'c'));

        $expectedParams = array( 'a', 'b', 'c');

        $this->assertEquals($expectedParams, $this->object->getGroup()->getParams());
    }
}
