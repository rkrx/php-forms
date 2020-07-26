<?php
namespace Forms\Form;

use Forms\Common\ComponentTestCase;
use Forms\Form\Validation\Result\ValidationResultMessage;

class DateTimePickerTest extends ComponentTestCase {
	public function testConvert() {
		self::assertEquals(['a' => ['b' => '2020-01-01T01:35:00+01:00']], $this->getComp()->convert(['a' => ['b' => '2020-01-01T01:35']]));
	}

	public function testConvertNonExistingKey() {
		self::assertEquals(['a' => ['b' => null]], $this->getComp()->convert(['a' => []]));
	}

	public function testValidate() {
		// Valid date is valid
		$result = $this->convertAndValidate($this->getComp(), ['a' => ['b' => '2020-01-01']]);
		self::assertTrue($result->isValid());
		self::assertEmpty($result->getMessages());

		// Valid date with time is a valid date
		$result = $this->convertAndValidate($this->getComp(), ['a' => ['b' => '2020-01-01T01:35']]);
		self::assertTrue($result->isValid());
		self::assertEmpty($result->getMessages());

		// Empty string is valid (as "not given value"; `required` should be used in complement here)
		$result = $this->convertAndValidate($this->getComp(), ['a' => ['b' => '']]);
		self::assertTrue($result->isValid());
		self::assertEmpty($result->getMessages());

		// `null` is valid (as "not given value"; `required` should be used in complement here)
		$result = $this->convertAndValidate($this->getComp(), ['a' => []]);
		self::assertTrue($result->isValid());
		self::assertEmpty($result->getMessages());
	}

	public function testValidateFailure() {
		$result = $this->convertAndValidate($this->getComp(), ['a' => ['b' => 'test']]);
		self::assertFalse($result->isValid());
		self::assertEquals([new ValidationResultMessage('Invalid date time')], $result->getMessages());
	}

	public function testRender() {
		$aeq = fn ($actual, $expected) => self::assertEquals($expected, $actual);
		$result = $this->getComp()->render(['a' => ['b' => '2020-01-01T01:35']], true);
		$aeq($result, [
			'name' => ['a', 'b'],
			'title' => 'Choose a date',
			'value' => '2020-01-01T01:35:00+01:00',
			'messages' => [],
			'attributes' => [],
			'type' => 'datetime-picker',
		]);
	}

	public function testRenderWithErrors() {
		$aeq = fn ($actual, $expected) => self::assertEquals($expected, $actual);
		$result = $this->getComp()->render(['a' => ['b' => 'test']], true);
		$aeq($result, [
			'name' => ['a', 'b'],
			'title' => 'Choose a date',
			'value' => 'test',
			'messages' => [new ValidationResultMessage('Invalid date time')],
			'attributes' => [],
			'type' => 'datetime-picker',
		]);
	}

	protected function getComp(): DateTimePicker {
		return new DateTimePicker(['a', 'b'], 'Choose a date', []);
	}
}
