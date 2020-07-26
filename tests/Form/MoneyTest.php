<?php
namespace Forms\Form;

use Forms\Form\Validation\Result\ValidationResultMessage;

class MoneyTest extends DecimalNumberTest {
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
			'converted-value' => 'test'
		]);
	}

	protected function getComp(): Money {
		return new Money(['a', 'b'], 'Money');
	}
}
