<?php
namespace Forms\Form\Validation;

use Forms\Form\Validation\Result\ValidationResultMessage;
use PHPUnit\Framework\TestCase;

class MaxDateTimeTest extends TestCase {
	private MaxDateTime $validator;

	public function setUp(): void {
		$this->validator = new MaxDateTime('2020-01-01');
	}

	public function testRender() {
		self::assertEquals(['xxx' => 123, 'attributes' => ['maxDateTime' => '2020-01-01 00:00']], $this->validator->render(['xxx' => 123]));
	}

	public function testSuccesssfulInvoke() {
		self::assertEquals([], $this->validator->__invoke(['a' => ['b' => '2000-01-01']], ['a', 'b']));
	}

	public function testFailingInvoke() {
		$expectedMessage = 'The maximum date for this field {maxDateTime} was exceeded';
		$expectedParams = ['maxDateTime' => '2020-01-01 00:00'];
		self::assertEquals([new ValidationResultMessage($expectedMessage, $expectedParams)], $this->validator->__invoke(['a' => ['b' => '2030-01-01']], ['a', 'b']));
	}
}
