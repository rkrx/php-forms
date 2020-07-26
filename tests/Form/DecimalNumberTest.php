<?php
namespace Forms\Form;

use Forms\Common\ComponentTestCase;
use Forms\Form\Validation\Result\ValidationResultMessage;

class DecimalNumberTest extends ComponentTestCase {
		public function testConvert() {
		self::assertEquals(['a' => ['b' => '123.45']], $this->getComp()->convert(['a' => ['b' => '123.45']]));
	}

	public function testConvertEmptyValue() {
		self::assertEquals(['a' => ['b' => '0.0']], $this->getComp()->convert(['a' => []]));
	}

	public function testValidate() {
		self::assertTrue($this->convertAndValidate($this->getComp(), ['a' => ['b' => '123.45']])->isValid());
	}

	public function testValidateFailure() {
		self::assertFalse($this->convertAndValidate($this->getComp(), ['a' => ['b' => 'test']])->isValid());
	}

	public function testRender() {
		self::assertEq($this->getComp()->render(['a' => ['b' => 123.45]], true), [
			'name' => ['a', 'b'],
			'title' => 'Number',
			'value' => '123.45',
			'messages' => [],
			'attributes' => [],
			'type' => 'decimal-number',
			'converted-value' => '123.45'
		]);
	}

	public function testRenderWithError() {
		self::assertEq($this->getComp()->render(['a' => ['b' => 'test']], true), [
			'name' => ['a', 'b'],
			'title' => 'Number',
			'value' => 'test',
			'messages' => [new ValidationResultMessage('Invalid number')],
			'attributes' => [],
			'type' => 'decimal-number',
			'converted-value' => 'test'
		]);
	}

	protected function getComp(): DecimalNumber {
		return new DecimalNumber(['a', 'b'], 'Number');
	}
}
