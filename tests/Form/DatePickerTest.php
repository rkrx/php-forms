<?php
namespace Forms\Form;

use Forms\Common\ComponentTestCase;
use Forms\Form\Validation\Result\ValidationResultMessage;

class DatePickerTest extends ComponentTestCase {
	public function testConvert() {
		self::assertEquals(['a' => ['b' => '2020-01-01']], $this->getComp()->convert(['a' => ['b' => '2020-01-01T01:35']]));
	}

	public function testConvertNonExistingKey() {
		self::assertEquals(['a' => ['b' => null]], $this->getComp()->convert(['a' => []]));
	}

	public function testValidate() {
		// Valid date is valid
		self::assertTrue($this->convertAndValidate($this->getComp(), ['a' => ['b' => '2020-01-01']])->isValid());

		// Valid date with time is a valid date
		self::assertTrue($this->convertAndValidate($this->getComp(), ['a' => ['b' => '2020-01-01T01:35']])->isValid());

		// Empty string is valid (as "not given value"; `required` should be used in complement here)
		self::assertTrue($this->convertAndValidate($this->getComp(), ['a' => ['b' => '']])->isValid());

		// `null` is valid (as "not given value"; `required` should be used in complement here)
		self::assertTrue($this->convertAndValidate($this->getComp(), ['a' => []])->isValid());
	}

	public function testValidateFailure() {
		$result = $this->convertAndValidate($this->getComp(), ['a' => ['b' => 'test']]);
		self::assertFalse($result->isValid());
		self::assertEquals([new ValidationResultMessage('Invalid date')], $result->getMessages());
	}

	public function testRender() {
		$aeq = fn ($actual, $expected) => self::assertEquals($expected, $actual);
		$result = $this->getComp()->render(['a' => ['b' => '2020-01-01T01:35']], true);
		$aeq($result, [
			'name' => ['a', 'b'],
			'title' => 'Choose a date',
			'value' => '2020-01-01',
			'messages' => [],
			'attributes' => [],
			'type' => 'datepicker',
		]);
	}

	public function testRenderWithErrors() {
		$aeq = fn ($actual, $expected) => self::assertEquals($expected, $actual);
		$result = $this->getComp()->render(['a' => ['b' => 'test']], true);
		$aeq($result, [
			'name' => ['a', 'b'],
			'title' => 'Choose a date',
			'value' => 'test',
			'messages' => [new ValidationResultMessage('Invalid date')],
			'attributes' => [],
			'type' => 'datepicker',
		]);
	}

	protected function getComp(): DatePicker {
		return $this->getFormElementProvider()->datePicker(['a', 'b'], 'Choose a date', []);
	}
}
