<?php

namespace POTests\QueryBuilder;

use PHPUnit_Framework_TestCase;
use PO\QueryBuilder;
use PO\QueryBuilder\Statements\Update;
use PO\QueryBuilder\Helper;

class UpdateTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var Update
     */
    protected $object;

    public function setUp()
    {
        $this->object = new Update();
        $this->object->getHelper()->setDoubleQuoted(true);
    }

    public function testGetUpdate()
    {
        $this->assertInstanceOf(
            'PO\QueryBuilder\Clauses\UpdateClause',
            $this->object->getUpdate()
        );
    }

    public function testGetSet()
    {
        $this->assertInstanceOf(
            'PO\QueryBuilder\Clauses\SetClause',
            $this->object->getSet()
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

    public function testGetDefaultHelper()
    {
        $this->assertInstanceOf(
            'PO\QueryBuilder\Helper',
            $this->object->getHelper()
        );
    }

    public function testOverridesHeleper()
    {
        $helper = new Helper();
        $options = array('helper' => $helper);
        $object = new QueryBuilder($options);
        $this->assertSame($helper, $object->getHelper());
    }

    public function testCanConvertQueryToString()
    {
        $sql = 'UPDATE table';
        $this->object->table('table');
        $this->assertEquals($sql, $this->object->toSql());

        $sql .= ' INNER JOIN table2';
        $this->object->innerJoin('table2');
        $this->assertEquals($sql, $this->object->toSql());

        $sql .= ' SET foo = "bar", age = 12';
        $this->object->set(array(
            'foo' => 'bar',
            'age' => 12
        ));
        $this->assertEquals($sql, $this->object->toSql());

        $sql .= ' WHERE a = "b" AND b = 1';
        $this->object->where('a', 'b')->where(array('b' => 1));
        $this->assertEquals($sql, $this->object->toSql());

        $sql .= ' ORDER BY foo, bar DESC';
        $this->object->orderBy(array('foo', 'bar DESC'));
        $this->assertEquals($sql, $this->object->toSql());

        $sql .= ' LIMIT 10';
        $this->object->limit(10);
        $this->assertEquals($sql, $this->object->toSql());

        $sql .= ', 2';
        $this->object->limit(10, 2);
        $this->assertEquals($sql, $this->object->toSql());
    }

    public function testGetSqlReplacingThePlaceHolders()
    {
        $this->object->table('table')->set(array(
            'name' => ':name',
            'age'  => ':age'
        ));

        $sql = 'UPDATE table SET name = "foo", age = 12';
        $params = array(
            'name' => 'foo',
            'age' => 12
        );

        $this->assertEquals($sql, $this->object->toSql($params));
    }

    public function testAddsInnerJoin()
    {
        $this->object->innerJoin('t1')->innerJoin('t2', 't1.id = t2.t1_id');
        $sql = 'INNER JOIN t1 INNER JOIN t2 ON t1.id = t2.t1_id';
        $this->assertEquals($sql, $this->object->getJoins()->toSql());
    }

    public function testAddsLeftJoin()
    {
        $this->object->leftJoin('t1')->leftJoin('t2', 't1.id = t2.t1_id');
        $sql = 'LEFT JOIN t1 LEFT JOIN t2 ON t1.id = t2.t1_id';
        $this->assertEquals($sql, $this->object->getJoins()->toSql());
    }

    public function testCallsToSqlWhenConvertingToString()
    {
        $this->assertEquals($this->object->toSql(), (string) $this->object);
    }

    public function testProvidesInterfaceForAddingConditions()
    {
        $this->object->where('a = 1')
            ->where('a', 'b')
            ->where('a', 'x', '!=')
            ->where(array(
                'foo' => 'bar',
                'foobar' => 'foo'
            ));

        $expectedParams = array(
            'a = 1',
            'a = "b"',
            'a != "x"',
            'foo = "bar"',
            'foobar = "foo"',
        );

        $this->assertEquals(
            $expectedParams,
            $this->object->getWhere()->getParams()
        );
    }

    public function testProvidesInterfaceForAddingOrder()
    {
        $this->object->orderBy('a')->orderBy(array('b', 'c'));

        $expectedParams = array( 'a', 'b', 'c');

        $this->assertEquals(
            $expectedParams,
            $this->object->getOrder()->getParams()
        );
    }
}
