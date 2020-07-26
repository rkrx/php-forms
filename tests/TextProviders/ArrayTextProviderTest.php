<?php
namespace Forms\TextProviders;

use PHPUnit\Framework\TestCase;

class ArrayTextProviderTest extends TestCase {
	private ArrayTextProvider $provider;

	public function setUp(): void {
		$this->provider = new ArrayTextProvider(['test' => ['Hello {name}!' => 'Hola {name}!']]);
	}

	public function testTranslate() {
		$this->doTestMethod($this->provider, 'translate');
	}

	public function testT() {
		$this->doTestMethod($this->provider, 't');
	}

	public function test__invoke() {
		$this->doTestMethod($this->provider, '__invoke');
	}

	private function doTestMethod(ArrayTextProvider $obj, string $method) {
		$fn = fn (...$args) => $obj->{$method}(...$args);
		self::assertEquals('Hola Max!', $fn('test', 'Hello {name}!', ['name' => 'Max']));
	}
}
