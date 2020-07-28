<?php
namespace Forms\Form;

use Forms\Common\ComponentTestCase;
use Forms\Form\Validation\Result\ValidationResultMessage;

class MoneyTest extends ComponentTestCase {
	public function testConvert() {
		$value = $this->getComp()->convert(['a' => ['b' => '123.45678']]);
		self::assertEquals(['a' => ['b' => '123.46']], $value);
	}

	public function testConvertEmptyValue() {
		self::assertEquals(['a' => ['b' => '0.00']], $this->getComp()->convert(['a' => []]));
	}

	public function testValidate() {
		self::assertTrue($this->convertAndValidate($this->getComp(), ['a' => ['b' => '123.46']])->isValid());
	}

	public function testValidateFailure() {
		self::assertFalse($this->convertAndValidate($this->getComp(), ['a' => ['b' => 'test']])->isValid());
	}

	public function testRender() {
		self::assertEq($this->getComp()->render(['a' => ['b' => 123.45]], true), [
			'name' => ['a', 'b'],
			'title' => 'Money',
			'value' => '123.45',
			'messages' => [],
			'attributes' => [],
			'type' => 'money',
			'converted-value' => '123.45'
		]);
	}

	public function testRenderWithError() {
		self::assertEq($this->getComp()->render(['a' => ['b' => 'test']], true), [
			'name' => ['a', 'b'],
			'title' => 'Money',
			'value' => 'test',
			'messages' => [new ValidationResultMessage('Invalid number')],
			'attributes' => [],
			'type' => 'money',
			'converted-value' => '0.00'
		]);
	}

	protected function getComp(): Money {
		return $this->getFormElementProvider()->money(['a', 'b'], 'Money');
	}
}
