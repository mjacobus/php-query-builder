<?php

require_once 'Gs/QueryBuilder/Select.php';

class Gs_QueryBuilder_SelectTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var Gs_QueryBuilder_Select
     */
    protected $o;

    public function setUp()
    {
        $this->o = new Gs_QueryBuilder_Select();
        $this->o->getHelper()->setDoubleQuoted(true);
    }

    /**
     * @test
     */
    public function itInitializesWithTheCorrectSelectStatement()
    {
        $this->assertInstanceOf('Gs_QueryBuilder_SelectStatement', $this->o->getSelect());
    }

    /**
     * @test
     */
    public function itInitializesWithTheCorrectFromStatement()
    {
        $this->assertInstanceOf('Gs_QueryBuilder_FromStatement', $this->o->getFrom());
    }

    /**
     * @test
     */
    public function itInitializesWithTheCorrectWhereStatement()
    {
        $this->assertInstanceOf('Gs_QueryBuilder_WhereStatement', $this->o->getWhere());
    }

    /**
     * @test
     */
    public function itInitializesWithTheCorrectOrderStatement()
    {
        $this->assertInstanceOf('Gs_QueryBuilder_OrderStatement', $this->o->getOrder());
    }

    /**
     * @test
     */
    public function itInitializesWithTheCorrectLimitStatement()
    {
        $this->assertInstanceOf('Gs_QueryBuilder_LimitStatement', $this->o->getLimit());
    }

    /**
     * @test
     */
    public function itInitializesWithTheCorrectJoinsStatement()
    {
        $this->assertInstanceOf('Gs_QueryBuilder_JoinStatement', $this->o->getJoins());
    }

    /**
     * @test
     */
    public function itInitializesWithTheCorrectGroupStatement()
    {
        $this->assertInstanceOf('Gs_QueryBuilder_GroupStatement', $this->o->getGroup());
    }

    /**
     * @test
     */
    public function itCanOverrideTheHelperCorrectHelper()
    {
        $this->assertInstanceOf('Gs_QueryBuilder_Helper', $this->o->getHelper());
    }

    /**
     * @test
     */
    public function itInitializesWithTheCorrectHelper()
    {
        $helper = new Gs_QueryBuilder_Helper();
        $options = array('helper' => $helper);
        $object = new Gs_QueryBuilder($options);
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



}
