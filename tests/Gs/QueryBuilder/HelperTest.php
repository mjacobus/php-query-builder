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
        $this->o->setDoubleQuoted(true);
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

        $this->o->setDoubleQuoted(false);

        $this->assertEquals("'a'", $this->o->quote('a'));
        $this->assertEquals("'abc'", $this->o->quote('abc'));
        $this->assertEquals("'1'", $this->o->quote('1'));
        $this->assertEquals("'a\'bc\''", $this->o->quote("a'bc'"));
        $this->assertEquals("'a\'bc'", $this->o->quote('a\'bc'));
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

    /**
     * @test
     */
    public function itCanConverValueToTheDbEquivalentValue()
    {
        $this->assertEquals('NULL', $this->o->toDbValue(null));
        $this->assertEquals('FALSE', $this->o->toDbValue(false));
        $this->assertEquals('TRUE', $this->o->toDbValue(true));
        $this->assertEquals('"abc"', $this->o->toDbValue('abc'));
        $this->assertEquals(':placeholder', $this->o->toDbValue(':placeholder'));

        $arrayValue = $this->o->toDbValue(array('value' => '0000'));
        $this->assertEquals('0000', $arrayValue);
        $this->assertInternalType('string', $arrayValue);
    }

    /**
     * @test
     */
    public function itCanReplacePlaceholders()
    {
        $string =  'the name is :lastname, :name :lastname.';

        $expectedString = 'the name is Bond, James Bond.';

        $result = $this->o->replacePlaceholders(
            $string,
            array(
                'name'     => 'James',
                'lastname' => 'Bond',
            ),
            false
        );
        $this->assertEquals($expectedString, $result);
    }

}
