<?php
namespace Forms\Form\Validation;

use Forms\Form\Validation\Result\ValidationResultMessage;
use PHPUnit\Framework\TestCase;

class MinLengthTest extends TestCase {
	private MinLength $validator;

	public function setUp(): void {
		$this->validator = new MinLength(3);
	}

	public function testRender() {
		self::assertEquals(['xxx' => 123, 'attributes' => ['minLength' => 3]], $this->validator->render(['xxx' => 123]));
	}

	public function testSuccesssfulInvoke() {
		self::assertEmpty($this->validator->__invoke(['a' => ['b' => 'abc']], ['a', 'b']));
	}

	public function testFailingInvoke() {
		$expectedMessage = 'Minimum length of {length} missed by {missedBy} characters';
		$expectedParams = ['length' => 3, 'actualLength' => 2, 'missedBy' => 1];
		self::assertEquals([new ValidationResultMessage($expectedMessage, $expectedParams)], $this->validator->__invoke(['a' => ['b' => 'ab']], ['a', 'b']));
	}
}
