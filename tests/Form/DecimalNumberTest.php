<?php
namespace Forms\Form;

use Forms\Common\ComponentTestCase;
use Forms\Form\Validation\Result\ValidationResultMessage;

class DecimalNumberTest extends ComponentTestCase {
	public function testConvert() {
		$value = $this->getComp()->convert(['a' => ['b' => '123.45678']]);
		self::assertEquals(['a' => ['b' => '123.4568']], $value);
	}

	public function testConvertEmptyValue() {
		self::assertEquals(['a' => ['b' => '0.0000']], $this->getComp()->convert(['a' => []]));
	}

	public function testValidate() {
		self::assertTrue($this->convertAndValidate($this->getComp(), ['a' => ['b' => '123.45678']])->isValid());
	}

	public function testValidateFailure() {
		self::assertFalse($this->convertAndValidate($this->getComp(), ['a' => ['b' => 'test']])->isValid());
	}

	public function testRender() {
		self::assertEq($this->getComp()->render(['a' => ['b' => 123.45678]], true), [
			'name' => ['a', 'b'],
			'title' => 'Number',
			'value' => '123.45678',
			'valid' => true,
			'messages' => [],
			'attributes' => [],
			'type' => 'decimal-number',
			'converted-value' => '123.4568'
		]);
	}

	public function testRenderWithError() {
		self::assertEq($this->getComp()->render(['a' => ['b' => 'test']], true), [
			'name' => ['a', 'b'],
			'title' => 'Number',
			'value' => 'test',
			'valid' => false,
			'messages' => [new ValidationResultMessage('Invalid number')],
			'attributes' => [],
			'type' => 'decimal-number',
			'converted-value' => '0.0000'
		]);
	}

	protected function getComp(): DecimalNumber {
		return $this->getFormElementProvider()->decimal(['a', 'b'], 'Number');
	}
}
