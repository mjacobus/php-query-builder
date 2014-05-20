<?php

namespace POTests\QueryBuilder;

use PHPUnit_Framework_TestCase;
use PO\QueryBuilder;
use PO\QueryBuilder\UpdateStatement;

/**
 * @author Marcelo Jacobus <marcelo.jacobus@gmail.com>
 */
class UpdateStatementTest extends PHPUnit_Framework_TestCase
{

    /**
     * @param PO\QueryBuilder\UpdateStatement
     */
    protected $o;

    public function setUp()
    {
        $this->o = new UpdateStatement(new QueryBuilder);
    }

    /**
     * @test
     */
    public function itSetQueryBuilderOnTheConstructor()
    {
        $this->assertInstanceOf('PO\QueryBuilder\Statement', $this->o);
    }

    /**
     * @test
     */
    public function itConvertsCorrectlyToString()
    {
        $this->o->table('table');

        $this->assertEquals('UPDATE table', $this->o->toString());
    }
}
