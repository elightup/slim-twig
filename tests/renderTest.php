<?php
namespace Tests;

use PHPUnit\Framework\TestCase;
use SlimTwig\Renderer;

class RenderTest extends TestCase
{

    public function testSingleVariable()
    {
        $originalContent  = 'Hello {{ name }}';
        $expectedResult = 'Hello World';

        $twig   = new Renderer();
        $result = $twig::render( $originalContent, [ 'name' => 'World' ] );

        $this->assertEquals( $expectedResult, $result );
    }

    public function testSingleVariableWithDot()
    {
        $originalContent  = 'Hello {{ name.first }}';
        $expectedResult = 'Hello World';

        $twig   = new Renderer();
        $result = $twig::render( $originalContent, [ 'name' => [ 'first' => 'World' ] ] );

        $this->assertEquals( $expectedResult, $result );
    }

    public function testMultiVariable()
    {
        $originalContent  = 'Hello {{ name.first }}. Check out new plugin {{ plugin }} {{ not_exists }}';
        $expectedResult = 'Hello World. Check out new plugin SlimTwig ';

        $twig   = new Renderer();
        $result = $twig::render( $originalContent, [ 'name' => [ 'first' => 'World' ], 'plugin' => 'SlimTwig' ] );

        $this->assertEquals( $expectedResult, $result );
    }

    public function testUnStandardVariable()
    {
        $originalContent  = 'Hello {{ person.first.name }}. { this is something new }, or {{ is a broken brackets';
        $expectedResult = 'Hello World. { this is something new }, or {{ is a broken brackets';

        $twig   = new Renderer();
        $result = $twig::render( $originalContent, [ 'person' => [ 'first' => [ 'name' => 'World' ] ] ] );

        $this->assertEquals( $expectedResult, $result );
    }

}
