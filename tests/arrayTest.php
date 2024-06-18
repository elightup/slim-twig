<?php
namespace Tests;

use PHPUnit\Framework\TestCase;
use App\SlimTwig;

class ArrayTest extends TestCase
{

    public function testKeyIsSingle()
    {
        $originalArray = [
            'foo' => 'bar',
        ];
        $expectedResult = true;

        $twig   = new SlimTwig();
        $result = $twig->get( $originalArray, 'foo' );

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

        $twig   = new SlimTwig();
        $result = $twig->get( $originalArray, 'foo.bar', true );

        $this->assertEquals( $expectedResult, $result );
    }

}
