<?php
namespace Forms\Form\Validation;

use Forms\Form\Validation\Result\ValidationResultMessage;
use PHPUnit\Framework\TestCase;

class MinDateTimeTest extends TestCase {
	private MinDateTime $validator;

	public function setUp(): void {
		$this->validator = new MinDateTime('2020-01-01');
	}

	public function testRender() {
		self::assertEquals(['xxx' => 123, 'attributes' => ['minDateTime' => '2020-01-01 00:00']], $this->validator->render(['xxx' => 123]));
	}

	public function testSuccesssfulInvoke() {
		self::assertEquals([], $this->validator->__invoke(['a' => ['b' => '2030-01-01']], ['a', 'b']));
		self::assertEquals([], $this->validator->__invoke(['a' => ['b' => '2020-01-01']], ['a', 'b']));
	}

	public function testFailingInvoke() {
		$expectedMessage = 'The minimum date for this field {minDateTime} was not reached';
		$expectedParams = ['minDateTime' => '2020-01-01 00:00'];
		self::assertEquals([new ValidationResultMessage($expectedMessage, $expectedParams)], $this->validator->__invoke(['a' => ['b' => '2010-01-01']], ['a', 'b']));
	}
}
