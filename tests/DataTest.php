<?php
namespace Tests;

require __DIR__ . '/../src/Data.php';

use PHPUnit\Framework\TestCase;
use SlimTwig\Data;

class GetTest extends TestCase {
	public function testKeyIsSingle() {
		$originalArray  = [
			'foo' => 'bar',
		];
		$expectedResult = 'bar';

		$twig   = new Data();
		$result = $twig::get( $originalArray, 'foo' );

		$this->assertEquals( $expectedResult, $result );
	}

	public function testKeyIsMulti() {
		$originalArray  = [
			'foo' => [
				'bar' => 'baz',
			],
		];
		$expectedResult = 'baz';

		$twig   = new Data();
		$result = $twig::get( $originalArray, 'foo.bar', true );

		$this->assertEquals( $expectedResult, $result );
	}

	public function testKeyIsObject() {
		$originalArray  = [
			'foo' => (object) [
				'bar' => 'baz',
				'pax' => 'vax',
			],
		];
		$expectedResult = 'baz';

		$twig   = new Data();
		$result = $twig::get( $originalArray, 'foo.bar', true );

		$this->assertEquals( $expectedResult, $result );
	}

	public function testKeyIsObjectObject() {
		$originalArray  = (object) [
			'foo' => (object) [
				'bar' => [
					'baz' => 'baz value',
				],
				'pax' => 'vax',
			],
		];
		$expectedResult = 'baz value';

		$twig   = new Data();
		$result = $twig::get( $originalArray, 'foo.bar.baz', true );

		$this->assertEquals( $expectedResult, $result );
	}
}
