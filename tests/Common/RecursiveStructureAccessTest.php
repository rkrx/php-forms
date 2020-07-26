<?php
namespace Forms\Common;

use Forms\Form\Common\RecursiveStructureAccess as RSA;
use PHPUnit\Framework\TestCase;

class RecursiveStructureAccessTest extends TestCase {
	public function testHas() {
		self::assertTrue(RSA::has(['a' => ['b' => 1]], ['a', 'b']));
		self::assertFalse(RSA::has(['a' => ['b' => 1]], ['a', 'c']));
	}

	public function testGet() {
		$data = ['a' => 1];
		$value = RSA::get($data, ['a', 'b'], 123);
		self::assertEquals(123, $value);

		$data = ['a' => ['b' => ['c' => 456]]];
		$value = RSA::get($data, ['a', 'b'], 123);
		self::assertEquals(['c' => 456], $value);
	}

	public function testSet() {
		$data = [];
		$data = RSA::set($data, ['a', 'b'], 123);
		self::assertEquals(['a' => ['b' => 123]], $data);

		$data = ['a' => 1];
		$data = RSA::set($data, ['a', 'b'], 123);
		self::assertEquals(['a' => ['b' => 123]], $data);

		$data = ['a' => ['b' => ['c' => 123]]];
		$data = RSA::set($data, ['a', 'b'], 123);
		self::assertEquals(['a' => ['b' => 123]], $data);
	}

	public function testRemove() {
		self::assertEquals(['d' => 123], RSA::remove(['a' => ['b' => ['c' => 123]], 'd' => 123], ['a']));
		self::assertEquals(['a' => ['d' => 123]], RSA::remove(['a' => ['b' => ['c' => 123], 'd' => 123]], ['a', 'b']));
		self::assertEquals(['a' => ['b' => ['d' => 123]]], RSA::remove(['a' => ['b' => ['c' => 123, 'd' => 123]]], ['a', 'b', 'c']));
	}
}
