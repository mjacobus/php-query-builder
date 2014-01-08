<?php

/**
 * @author Marcelo Jacobus <marcelo.jacobus@gmail.com>
 */
class Gs_QueryBuilder_HelperTest extends PHPUnit_Framework_TestCase
{

    /**
     * @param Gs_QueryBuilder_Helper
     */
    protected $o;

    public function setUp()
    {
        $this->o = new Gs_QueryBuilder_Helper;
    }

    /**
     * @test
     */
    public function itVerifiesIfValueIsNumber()
    {
        $this->assertTrue($this->o->isNumber(1));
        $this->assertTrue($this->o->isNumber('1'));
        $this->assertTrue($this->o->isNumber('1.1'));
        $this->assertFalse($this->o->isNumber('1.1a'));
        $this->assertFalse($this->o->isNumber('a'));
        $this->assertFalse($this->o->isNumber('1,2'));
    }

    /**
     * @test
     */
    public function itQuotesValueIfIsNecessary()
    {
        $this->assertEquals(1, $this->o->quoteIfNecessary(1));
        $this->assertEquals('1', $this->o->quoteIfNecessary('1'));
        $this->assertEquals('"a"', $this->o->quoteIfNecessary('a'));
        $this->assertEquals(':placeholder', $this->o->quoteIfNecessary(':placeholder'));
    }

    /**
     * @test
     */
    public function itQuotesValue()
    {
        $this->assertEquals('"a"', $this->o->quote('a'));
        $this->assertEquals('"abc"', $this->o->quote('abc'));
        $this->assertEquals('"1"', $this->o->quote('1'));
        $this->assertEquals('"a\"bc\""', $this->o->quote('a"bc"'));
        $this->assertEquals('"a\'bc"', $this->o->quote('a\'bc'));
    }

    /**
     * @test
     */
    public function itVerifiesIfValueIsPlaceholder()
    {
        $this->assertTrue($this->o->isPlaceholder(':placeholder'));
        $this->assertTrue($this->o->isPlaceholder(':placeHolder'));
        $this->assertTrue($this->o->isPlaceholder(':place_Holder'));
        $this->assertFalse($this->o->isPlaceholder('s:st'));
        $this->assertFalse($this->o->isPlaceholder('string'));
        $this->assertFalse($this->o->isPlaceholder('1'));
    }

}
