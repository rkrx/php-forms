<?php
namespace Forms\Form;

use Forms\Common\ComponentTestCase;
use Forms\Form\Common\InvalidValue;
use Forms\Form\Validation\Result\ValidationResultMessage;

class IntegerNumberTest extends ComponentTestCase {
	public function testConvert() {
		self::assertEquals(['a' => ['b' => 123]], $this->getComp()->convert(['a' => ['b' => 123]]));
	}

	public function testConvertNullValue() {
		self::assertEquals(['a' => ['b' => 0]], $this->getComp()->convert(['a' => ['b' => null]]));
	}

	public function testConvertNonNumber() {
		self::assertEquals(['a' => ['b' => new InvalidValue('test')]], $this->getComp()->convert(['a' => ['b' => 'test']]));
	}

	public function testValidate() {
		self::assertTrue($this->getComp()->validate(['a' => ['b' => 123]])->isValid());
	}

	public function testValidateFailure() {
		self::assertFalse($this->getComp()->validate(['a' => ['b' => 'test']])->isValid());
		self::assertEquals([new ValidationResultMessage('Invalid value')], $this->getComp()->validate(['a' => ['b' => 'test']])->getMessages());
	}

	public function testRender() {
		self::assertEq($this->getComp()->render(['a' => ['b' => 123]], true), [
			'name' => ['a', 'b'],
			'title' => 'Integer Input',
			'value' => 123,
			'valid' => true,
			'messages' => [],
			'attributes' => ['xyz' => 123],
			'type' => 'integer-number'
		]);
	}

	public function testRenderWithNegativeValidationResult() {
		self::assertEq($this->getComp()->render(['a' => ['b' => 'test']], true), [
			'name' => ['a', 'b'],
			'title' => 'Integer Input',
			'value' => 'test',
			'valid' => false,
			'messages' => [new ValidationResultMessage('Invalid value')],
			'attributes' => ['xyz' => 123],
			'type' => 'integer-number'
		]);
	}

	protected function getComp(): IntegerNumber {
		return $this->getFormElementProvider()->integer(['a', 'b'], 'Integer Input', ['xyz' => 123]);
	}
}
