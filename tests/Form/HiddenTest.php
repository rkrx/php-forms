<?php
namespace Forms\Form;

use Forms\Common\ComponentTestCase;

class HiddenTest extends ComponentTestCase {
	public function testConvert() {
		self::assertEquals(['a' => ['b' => ['abc' => ['def' => 123]]]], $this->getComp()->convert(['a' => ['b' => json_encode(['abc' => ['def' => 123]])]]));
	}

	public function testValidate() {
		self::assertTrue(self::convertAndValidate($this->getComp(), ['a' => ['b' => json_encode(['abc' => ['def' => 123]])]])->isValid());
	}

	public function testRender() {
		self::assertEq($this->getComp()->render(['a' => ['b' => ['abc' => ['def' => 123]]]]), [
			'name' => ['a', 'b'],
			'title' => 'Hidden',
			'value' => ['abc' => ['def' => 123]],
			'messages' => [],
			'attributes' => ['x' => 123],
			'type' => 'hidden'
		]);
	}

	protected function getComp(): Hidden {
		return new Hidden(['a', 'b'], 'Hidden', ['x' => 123]);
	}
}
