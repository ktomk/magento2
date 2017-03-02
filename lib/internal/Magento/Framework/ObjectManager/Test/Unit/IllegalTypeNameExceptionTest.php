<?php

/*
 * This file is part Magento
 */

namespace Magento\Framework\ObjectManager\Test\Unit;


use Magento\Framework\ObjectManager\IllegalTypeNameException;

/**
 * Class IllegalTypeNameExceptionTest
 * @package Magento\Framework\ObjectManager\Test\Unit
 */
class IllegalTypeNameExceptionTest extends \PHPUnit_Framework_TestCase
{
    public function provideAssertions()
    {
        return [
            ['HelloWorld', 1], # no trailing backslash
            ['\HelloWorld', 0], # trailing backslash
            ['Hello\World', 1], # namespaced
            ['00foo\Bar', 0], # trailing digits
            ['Bar\00foo', 0], # trailing digits in classname
        ];
    }

    /**
     * @dataProvider provideAssertions
     */
    public function testAssertion($type, $asserts)
    {
        $asserts = (bool)$asserts;

        $result = null;
        try {
            $result = IllegalTypeNameException::assert($type);
            $this->assertTrue($asserts, "$type asserts");
        } catch (IllegalTypeNameException $ex) {
            $this->assertFalse($asserts, "$type asserts not");
        }

        $expected = $asserts ? $type : null;
        $this->assertSame($expected, $result, 'assert() should return the asserted type name');
    }
}
