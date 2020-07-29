<?php
namespace Forms\Form;

use Forms\Common\ComponentTestCase;
use Forms\Form\Common\InvalidValue;
use Forms\Form\Validation\Result\ValidationResultMessage;

class DropdownTest extends ComponentTestCase {
	public function testConvert() {
		// Convert existing options key
		self::assertEquals(['a' => ['b' => 1]], $this->getComp()->convert(['a' => ['b' => 'a']]));

		// Convert non existing options key
		self::assertEquals(['a' => ['b' => new InvalidValue('d')]], $this->getComp()->convert(['a' => ['b' => 'd']]));
	}

	public function testValidate() {
		// Convert existing options key
		self::assertTrue($this->getComp()->validate(['a' => ['b' => 'a']])->isValid());

		// Convert non existing options key
		self::assertFalse($this->getComp()->validate(['a' => ['b' => 'd']])->isValid());
	}

	public function testRender() {
		$aeq = fn ($actual, $expected) => self::assertEquals($expected, $actual);
		$aeq($this->getComp()->render(['a' => ['b' => 'a']], true), [
			'type' => 'dropdown',
			'value' => 'a',
			'valid' => true,
			'messages' => [],
			'attributes' => ['validation-messages' => ['Invalid selection' => 'Invalid selection']],
			'name' => ['a', 'b'],
			'title' => 'Dropdown',
			'options' => ['a' => 1, 'b' => 2, 'c' => 3],
		]);
	}

	public function testRenderWithError() {
		$aeq = fn ($actual, $expected) => self::assertEquals($expected, $actual);
		$aeq($this->getComp()->render(['a' => ['b' => 'd']], true), [
			'type' => 'dropdown',
			'attributes' => ['validation-messages' => ['Invalid selection' => 'Invalid selection']],
			'name' => ['a', 'b'],
			'title' => 'Dropdown',
			'valid' => false,
			'messages' => [new ValidationResultMessage('Invalid selection')],
			'options' => ['a' => 1, 'b' => 2, 'c' => 3],
		]);
	}

	protected function getComp(): Dropdown {
		return $this->getFormElementProvider()->dropdown(['a', 'b'], 'Dropdown', ['a' => 1, 'b' => 2, 'c' => 3]);
	}
}
