<?php

namespace POTests;

use PHPUnit_Framework_TestCase;
use PO\QueryBuilder;
use PO\QueryBuilder\Helper;

class QueryBuilderTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var QueryBuilder
     */
    protected $o;

    public function setUp()
    {
        $this->o = new QueryBuilder();
        $this->o->getHelper()->setDoubleQuoted(true);
    }

    /**
     * @test
     */
    public function itInitializesWithTheCorrectSelectStatement()
    {
        $this->assertInstanceOf('PO\QueryBuilder\SelectStatement', $this->o->getSelect());
    }

    /**
     * @test
     */
    public function itInitializesWithTheCorrectFromStatement()
    {
        $this->assertInstanceOf('PO\QueryBuilder\FromStatement', $this->o->getFrom());
    }

    /**
     * @test
     */
    public function itInitializesWithTheCorrectWhereStatement()
    {
        $this->assertInstanceOf('PO\QueryBuilder\WhereStatement', $this->o->getWhere());
    }

    /**
     * @test
     */
    public function itInitializesWithTheCorrectOrderStatement()
    {
        $this->assertInstanceOf('PO\QueryBuilder\OrderStatement', $this->o->getOrder());
    }

    /**
     * @test
     */
    public function itInitializesWithTheCorrectJoinsStatement()
    {
        $this->assertInstanceOf('PO\QueryBuilder\JoinStatement', $this->o->getJoins());
    }

    /**
     * @test
     */
    public function itInitializesWithTheCorrectGroupStatement()
    {
        $this->assertInstanceOf('PO\QueryBuilder\GroupStatement', $this->o->getGroup());
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
    public function itCanSetAddFieldsToTheSelectStatementAsStringAndReturnBuilder()
    {
        $object = $this->o->select('field')->select(array('one', 'two'));
        $this->assertSame($this->o, $object);
        $this->assertEquals(array('field', 'one', 'two'), $this->o->getSelect()->getParams());
    }

    /**
     * @test
     */
    public function itCanSetFromAsStringAndReturnBuilder()
    {
        $object = $this->o->from('table');
        $this->assertSame($this->o, $object);
        $this->assertEquals(array('table'), $this->o->getFrom()->getParams());

        $object = $this->o->from(array('table1', 'table2'));
        $this->assertEquals(array('table1', 'table2'), $this->o->getFrom()->getParams());
    }

    /**
     * @test
     */
    public function itCanConvertQueryToString()
    {
        $sql = 'SELECT a';
        $this->o->select('a');
        $this->assertEquals($sql, $this->o->toSql());

        $sql .= ' FROM table';
        $this->o->from('table');
        $this->assertEquals($sql, $this->o->toSql());

        $sql .= ' INNER JOIN table2';
        $this->o->innerJoin('table2');
        $this->assertEquals($sql, $this->o->toSql());

        $sql .= ' WHERE a = "b" AND b = 1';
        $this->o->where('a', 'b')->where(array('b' => 1));
        $this->assertEquals($sql, $this->o->toSql());

        $sql .= ' GROUP BY group1, group2';
        $this->o->groupBy(array('group1'))->groupBy('group2');
        $this->assertEquals($sql, $this->o->toSql());

        $sql .= ' ORDER BY foo, bar DESC';
        $this->o->orderBy(array('foo', 'bar DESC'));
        $this->assertEquals($sql, $this->o->toSql());
    }

    /**
     * @test
     */
    public function itGetSqlReplacingThePlaceHolders()
    {
        $this->o->from('table')->where(array(
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

        $this->assertEquals($sql, $this->o->toSql($params));
    }


    /**
     * @test
     */
    public function itAddsInnerJoin()
    {
        $this->o->from('table')->innerJoin('t1')->innerJoin('t2', 't1.id = t2.t1_id');
        $sql = 'INNER JOIN t1 INNER JOIN t2 ON t1.id = t2.t1_id';
        $this->assertEquals($sql, $this->o->getJoins()->toSql());
    }

    /**
     * @test
     */
    public function itAddsLeftJoin()
    {
        $this->o->from('table')->leftJoin('t1')->leftJoin('t2', 't1.id = t2.t1_id');
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

    /**
     * @test
     */
    public function itProvidesInterfaceForAddingGroup()
    {
        $this->o->groupBy('a')->groupBy(array('b', 'c'));

        $expectedParams = array( 'a', 'b', 'c');

        $this->assertEquals($expectedParams, $this->o->getGroup()->getParams());
    }

    /**
     * @test
     */
    public function canFactorySelect()
    {
        $query = QueryBuilder::factorySelect(array('a', 'b'));
        $this->assertInstanceOf('PO\QueryBuilder\Select', $query);
        $this->assertEquals('SELECT a, b', $query->toSql());
    }

    /**
     * @test
     */
    public function canFactoryUpdate()
    {
        $query = QueryBuilder::update('table')->addSet('foo', 'bar');
        $this->assertInstanceOf('PO\QueryBuilder\Update', $query);
        $this->assertEquals("UPDATE table SET foo = 'bar'", $query->toSql());
    }

    /**
     * @test
     */
    public function canFactoryInsert()
    {
        $query = QueryBuilder::insert('table')->values(array('foo' => 'bar'));
        $this->assertInstanceOf('PO\QueryBuilder\Insert', $query);
        $this->assertEquals("INSERT INTO table (foo) VALUES ('bar')", $query->toSql());
    }
}
