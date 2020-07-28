<?php
namespace Forms\Form;

use Forms\Common\ComponentTestCase;
use Forms\Form\Abstractions\AbstractInput;
use Forms\Form\Common\InvalidValue;
use Forms\Form\Validation\Result\ValidationResultMessage;

class RadioTest extends ComponentTestCase {
	public function testConvert() {
		self::assertEquals(['a' => ['b' => 3]], $this->getComp()->convert(['a' => ['b' => 'c']]));
	}

	public function testConvertFailure() {
		self::assertEquals(['a' => ['b' => new InvalidValue('d')]], $this->getComp()->convert(['a' => ['b' => 'd']]));
	}

	public function testValidate() {
		self::assertTrue($this->getComp()->validate(['a' => ['b' => 'c']])->isValid());
	}

	public function testValidateFailure() {
		self::assertFalse($this->getComp()->validate(['a' => ['b' => 'd']])->isValid());
		self::assertEquals([new ValidationResultMessage('Invalid selection')], $this->getComp()->validate(['a' => ['b' => 'd']])->getMessages());
	}

	public function testRender() {
		self::assertEq($this->getComp()->render(['a' => ['b' => 'a']], true), [
			'name' => ['a', 'b'],
			'title' => 'Radio-Button',
			'value' => 'a',
			'messages' => [],
			'attributes' => ['xyz' => 123],
			'type' => 'radio',
			'options' => ['a' => 1, 'b' => 2, 'c' => 3]
		]);
	}

	protected function getComp(): AbstractInput {
		return $this->getFormElementProvider()->radio(['a', 'b'], 'Radio-Button', ['a' => 1, 'b' => 2, 'c' => 3], ['xyz' => 123]);
	}
}
