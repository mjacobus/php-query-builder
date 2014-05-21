<?php

namespace POTests\QueryBuilder;

use PHPUnit_Framework_TestCase;
use PO\QueryBuilder;
use PO\QueryBuilder\Update;
use PO\QueryBuilder\Helper;

class UpdateTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var PO\QueryBuilder\Update
     */
    protected $o;

    public function setUp()
    {
        $this->o = new Update();
        $this->o->getHelper()->setDoubleQuoted(true);
    }

    /**
     * @test
     */
    public function itInitializesWithTheCorrectUpdateClause()
    {
        $this->assertInstanceOf('PO\QueryBuilder\Clauses\UpdateClause', $this->o->getUpdate());
    }

    /**
     * @test
     */
    public function itInitializesWithTheCorrectSetClause()
    {
        $this->assertInstanceOf('PO\QueryBuilder\Clauses\SetClause', $this->o->getSet());
    }

    /**
     * @test
     */
    public function itInitializesWithTheCorrectWhereClause()
    {
        $this->assertInstanceOf('PO\QueryBuilder\Clauses\WhereClause', $this->o->getWhere());
    }

    /**
     * @test
     */
    public function itInitializesWithTheCorrectOrderClause()
    {
        $this->assertInstanceOf('PO\QueryBuilder\Clauses\OrderClause', $this->o->getOrder());
    }

    /**
     * @test
     */
    public function itInitializesWithTheCorrectLimitClause()
    {
        $this->assertInstanceOf('PO\QueryBuilder\Clauses\LimitClause', $this->o->getLimit());
    }

    /**
     * @test
     */
    public function itInitializesWithTheCorrectJoinsClause()
    {
        $this->assertInstanceOf('PO\QueryBuilder\Clauses\JoinClause', $this->o->getJoins());
    }

    /**
     * @test
     */
    public function itCanOverrideTheHelperCorrectHelper()
    {
        $this->assertInstanceOf('PO\QueryBuilder\Helper', $this->o->getHelper());
    }

    /**
     * @test
     */
    public function itInitializesWithTheCorrectHelper()
    {
        $helper = new Helper();
        $options = array('helper' => $helper);
        $object = new QueryBuilder($options);
        $this->assertSame($helper, $object->getHelper());
    }

    /**
     * @test
     */
    public function itCanConvertQueryToString()
    {
        $sql = 'UPDATE table';
        $this->o->table('table');
        $this->assertEquals($sql, $this->o->toSql());

        $sql .= ' INNER JOIN table2';
        $this->o->innerJoin('table2');
        $this->assertEquals($sql, $this->o->toSql());

        $sql .= ' SET foo = "bar", age = 12';
        $this->o->set(array(
            'foo' => 'bar',
            'age' => 12
        ));
        $this->assertEquals($sql, $this->o->toSql());

        $sql .= ' WHERE a = "b" AND b = 1';
        $this->o->where('a', 'b')->where(array('b' => 1));
        $this->assertEquals($sql, $this->o->toSql());

        $sql .= ' ORDER BY foo, bar DESC';
        $this->o->orderBy(array('foo', 'bar DESC'));
        $this->assertEquals($sql, $this->o->toSql());

        $sql .= ' LIMIT 10';
        $this->o->limit(10);
        $this->assertEquals($sql, $this->o->toSql());

        $sql .= ', 2';
        $this->o->limit(10, 2);
        $this->assertEquals($sql, $this->o->toSql());
    }

    /**
     * @test
     */
    public function itGetSqlReplacingThePlaceHolders()
    {
        $this->o->table('table')->set(array(
            'name' => ':name',
            'age'  => ':age'
        ));

        $sql = 'UPDATE table SET name = "foo", age = 12';
        $params = array(
            'name' => 'foo',
            'age' => 12
        );

        $this->assertEquals($sql, $this->o->toSql($params));
    }


    /**
     * @test
     */
    public function itAddsInnerJoin()
    {
        $this->o->innerJoin('t1')->innerJoin('t2', 't1.id = t2.t1_id');
        $sql = 'INNER JOIN t1 INNER JOIN t2 ON t1.id = t2.t1_id';
        $this->assertEquals($sql, $this->o->getJoins()->toSql());
    }

    /**
     * @test
     */
    public function itAddsLeftJoin()
    {
        $this->o->leftJoin('t1')->leftJoin('t2', 't1.id = t2.t1_id');
        $sql = 'LEFT JOIN t1 LEFT JOIN t2 ON t1.id = t2.t1_id';
        $this->assertEquals($sql, $this->o->getJoins()->toSql());
    }

    /**
     * @test
     */
    public function itCallsToSqlWhenConvertingToString()
    {
        $this->assertEquals($this->o->toSql(), (string) $this->o);
    }

    /**
     * @test
     */
    public function itProvidesInterfaceForAddingConditions()
    {
        $this->o->where('a = 1')
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

        $this->assertEquals($expectedParams, $this->o->getWhere()->getParams());
    }

    /**
     * @test
     */
    public function itProvidesInterfaceForAddingOrder()
    {
        $this->o->orderBy('a')->orderBy(array('b', 'c'));

        $expectedParams = array( 'a', 'b', 'c');

        $this->assertEquals($expectedParams, $this->o->getOrder()->getParams());
    }
}
