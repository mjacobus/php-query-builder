<?php

namespace POTests\QueryBuilder;

use PHPUnit_Framework_TestCase;
use PO\QueryBuilder;
use PO\QueryBuilder\SetClause;

/**
 * @author Marcelo Jacobus <marcelo.jacobus@gmail.com>
 */
class SetClauseTest extends PHPUnit_Framework_TestCase
{

    /**
     * @param PO\QueryBuilder\SetClause
     */
    protected $o;

    public function setUp()
    {
        $this->o = new SetClause(new QueryBuilder);
        $this->o->getBuilder()->getHelper()->setDoubleQuoted(true);
    }

    /**
     * @test
     */
    public function itSetQueryBuilderOnTheConstructor()
    {
        $this->assertInstanceOf('PO\QueryBuilder\Clause', $this->o);
    }

    /**
     * @test
     */
    public function itCanConvertToSql()
    {
        $sql = 'SET name = "foo"';
        $this->o->set(array('name' => 'foo'));
        $this->assertEquals($sql, $this->o->toSql());

        $sql = 'SET name = "foo", age = 3';
        $this->o->addSet('age', '3');
        $this->assertEquals($sql, $this->o->toSql());
    }

    /**
     * @test
     */
    public function itReturnsEmptyStringWhenNoParamIsGiven()
    {
        $this->assertEquals('', $this->o->toSql());
    }

    /**
     * @test
     */
    public function itProvidesInterfaceToAddValuesToBeSet()
    {
        $this->o->addSet('a', 'b')->addSets(array(
            'c' => 1,
            'd' => 2
        ));

        $params = array(
            'a' => 'b',
            'c' => 1,
            'd' => 2
        );

        $this->assertEquals($params, $this->o->getParams());
    }

    /**
     * @test
     */
    public function itCanSetTheValues()
    {
        $params = array('r' => 1);

        $this->o->set(array('c' => 1))->set($params);

        $this->assertEquals($params, $this->o->getParams());
    }
}
