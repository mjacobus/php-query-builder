<?php

namespace POTests\QueryBuilder;

use PHPUnit_Framework_TestCase;
use PO\QueryBuilder;
use PO\QueryBuilder\UpdateClause;

/**
 * @author Marcelo Jacobus <marcelo.jacobus@gmail.com>
 */
class UpdateClauseTest extends PHPUnit_Framework_TestCase
{

    /**
     * @param PO\QueryBuilder\UpdateClause
     */
    protected $o;

    public function setUp()
    {
        $this->o = new UpdateClause(new QueryBuilder);
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
