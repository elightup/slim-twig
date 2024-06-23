<?php
namespace Tests;
include __DIR__ . "/../src/Data.php";

use PHPUnit\Framework\TestCase;
use SlimTwig\Data;

class GetTest extends TestCase
{

    public function testKeyIsSingle()
    {
        $originalArray = [
            'foo' => 'bar',
        ];
        $expectedResult = true;

        $twig   = new Data();
        $result = $twig::get( $originalArray, 'foo' );

        $this->assertEquals( $expectedResult, $result );
    }

    public function testKeyIsMulti()
    {
        $originalArray = [
            'foo' => [
                'bar' => 'baz',
            ],
        ];
        $expectedResult = true;

        $twig   = new Data();
        $result = $twig::get( $originalArray, 'foo.bar', true );

        $this->assertEquals( $expectedResult, $result );
    }


    public function testKeyIsObject()
    {
        $originalArray = [
            'foo' => (object) array(
                'bar' => 'baz',
                'pax' => 'vax'
            ),
        ];
        $expectedResult = true;

        $twig   = new Data();
        $result = $twig::get( $originalArray, 'foo.bar', true );

        $this->assertEquals( $expectedResult, $result );
    }

    public function testKeyIsObjectObject()
    {
        $originalArray = ( object )[
            'foo' => (object) array(
                'bar' => [
                    'baz' => 'baz value',
                ],
                'pax' => 'vax'
            ),
        ];
        $expectedResult = true;

        $twig   = new Data();
        $result = $twig::get( $originalArray, 'foo.bar.baz', true );

        $this->assertEquals( $expectedResult, $result );
    }


}
