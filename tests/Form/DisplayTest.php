<?php
namespace Forms\Form;

use Forms\Common\ComponentTestCase;
use Forms\Form\Abstractions\AbstractInput;

class DisplayTest extends ComponentTestCase {
	public function testConvert() {
		self::assertEquals([], $this->getComp()->convert([]));
	}

	public function testValidate() {
		self::assertTrue($this->getComp()->validate([])->isValid());
	}

	public function testRender() {
		self::assertEq($this->getComp()->render(['a' => ['b' => 123]], true), [
			'name' => ['a', 'b'],
			'title' => 'Display',
			'value' => 123,
			'messages' => [],
			'attributes' => ['x' => 123],
			'type' => 'display'
		]);
	}

	protected function getComp(): AbstractInput {
		return $this->getFormElementProvider()->display(['a', 'b'], 'Display', ['x' => 123]);
	}
}
