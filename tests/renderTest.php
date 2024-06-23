<?php
namespace Tests;

use PHPUnit\Framework\TestCase;
use SlimTwig\Renderer;

class RenderTest extends TestCase
{
    /**
     * @param string $originalString String to be sluggified
     * @param string $expectedResult What we expect our slug result to be
     *
     * @dataProvider providerTestRender
     */
    public function testRender( $originalContent, $expectedResult )
    {
        $data = [
            'plugin' => 'SlimTwig',
            'person' => [
                'first' => [
                    'name' => 'World',
                ],
            ],
        ];

        $twig   = new Renderer();
        $result = $twig::render( $originalContent, $data );

        $this->assertEquals( $expectedResult, $result );
    }

    public static function providerTestRender()
    {
        return [
            [
                'Hello World. Check out new plugin SlimTwig', //no variable
                'Hello World. Check out new plugin SlimTwig'
            ],
            [
                'Hello {{ plugin }}', //single variable
                'Hello SlimTwig'
            ],
            [
                'Hello {{ person.first }}. Check out new plugin {{ plugin }}{{ not_exists }}', // Array and not exists variable
                'Hello Array. Check out new plugin SlimTwig'
            ],
            [
                'Hello {{ person.first.name }}. { this is something new }, or {{ is a broken brackets', // Unstandard variable
                'Hello World. { this is something new }, or {{ is a broken brackets'
            ],
        ];
    }
}
