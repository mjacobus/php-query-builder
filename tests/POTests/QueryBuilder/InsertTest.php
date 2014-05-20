<?php

namespace POTests\QueryBuilder;

use PHPUnit_Framework_TestCase;
use PO\QueryBuilder;
use PO\QueryBuilder\Insert;

class InsertTest extends PHPUnit_Framework_TestCase
{

    /**
     * @var PO\QueryBuilder\Insert
     */
    protected $o;

    public function setUp()
    {
        $this->o = new PO\QueryBuilder\Insert;
        $this->o->getHelper()->setDoubleQuoted(true);
    }

    /**
     * @test
     */
    public function itIsAQueryBuilderAbstract()
    {
        $this->assertInstanceOf('PO\QueryBuilder\Abstract', $this->o);
    }


    /**
     * @test
     */
    public function itResolvesSql()
    {
        $this->o->into('table_name')->values(array(
            'field_1' => 'some_value',
            'number'  => 1,
            'id'      => '2',
        ));

        $sql = 'INSERT INTO table_name (field_1, number, id) VALUES ("some_value", 1, 2)';
        $this->assertEquals($sql, $this->o->toSql());
    }

    /**
     * @test
     */
    public function itResolvesSqlReplacingPlaceholders()
    {
        $this->o->into('table_name')->values(array(
            'name' => ':name',
            'age'  => ':age',
        ));

        $sql = 'INSERT INTO table_name (name, age) VALUES ("foo", 18)';
        $this->assertEquals($sql, $this->o->toSql(array(
                'name' => 'foo',
                'age'  => 18
        )));
    }
}
