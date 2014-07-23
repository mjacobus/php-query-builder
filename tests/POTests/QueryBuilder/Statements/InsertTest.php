<?php

namespace POTests\QueryBuilder\Statements;

use PHPUnit_Framework_TestCase;
use PO\QueryBuilder;
use PO\QueryBuilder\Statements\Insert;

class InsertTest extends PHPUnit_Framework_TestCase
{

    /**
     * @var Insert
     */
    protected $object;

    public function setUp()
    {
        $this->object = new Insert;
        $this->object->getHelper()->setDoubleQuoted(true);
    }

    public function testIsAQueryBuilderBase()
    {
        $this->assertInstanceOf(
            'PO\QueryBuilder\Statements\Base',
            $this->object
        );
    }

    public function testResolvesSql()
    {
        $this->object->into('table_name')->values(array(
            'field_1' => 'some_value',
            'number'  => 1,
            'id'      => '2',
        ));

        $sql = 'INSERT INTO table_name (field_1, number, id)'
             . ' VALUES ("some_value", 1, 2)';

        $this->assertEquals($sql, $this->object->toSql());

        $sql .= ' RETURNING id';
        $this->object->returning('id');
        $this->assertEquals($sql, $this->object->toSql());

        $sql .= ', name, last_name';
        $this->object->returning(array('name', 'last_name'));
        $this->assertEquals($sql, $this->object->toSql());
    }

    public function testResolvesSqlReplacingPlaceholders()
    {
        $this->object->into('table_name')->values(array(
            'name' => ':name',
            'age'  => ':age',
        ));

        $sql = 'INSERT INTO table_name (name, age) VALUES ("foo", 18)';
        $this->assertEquals($sql, $this->object->toSql(array(
                'name' => 'foo',
                'age'  => 18
        )));
    }
}
