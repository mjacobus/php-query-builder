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

    /**
     * @test
     */
    public function canFactorySelect()
    {
        $query = QueryBuilder::factorySelect(array('a', 'b'));
        $this->assertInstanceOf('PO\QueryBuilder\Statements\Select', $query);
        $this->assertEquals('SELECT a, b', $query->toSql());
    }

    /**
     * @test
     */
    public function canFactoryUpdate()
    {
        $query = QueryBuilder::update('table')->addSet('foo', 'bar');
        $this->assertInstanceOf('PO\QueryBuilder\Statements\Update', $query);
        $this->assertEquals("UPDATE table SET foo = 'bar'", $query->toSql());
    }

    /**
     * @test
     */
    public function canFactoryInsert()
    {
        $query = QueryBuilder::insert('table')->values(array('foo' => 'bar'));
        $this->assertInstanceOf('PO\QueryBuilder\Statements\Insert', $query);
        $this->assertEquals("INSERT INTO table (foo) VALUES ('bar')", $query->toSql());
    }
}
