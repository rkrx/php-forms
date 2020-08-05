<?php
namespace Forms\Form\Validation;

use Forms\Form\Validation\Result\ValidationResultMessage;
use PHPUnit\Framework\TestCase;

class HasMinValueTest extends TestCase {
	private HasMaxLength $validator;

	public function setUp(): void {
		$this->validator = new HasMaxLength(3);
	}

	public function testRender() {
		self::assertEquals(['xxx' => 123, 'attributes' => ['maxLength' => 3]], $this->validator->render(['xxx' => 123]));
	}

	public function testSuccesssfulInvoke() {
		self::assertEmpty($this->validator->__invoke(['a' => ['b' => 'abc']], ['a', 'b']));
	}

	public function testFailingInvoke() {
		$expectedMessage = 'Maximum length of {length} exceeded by {exceededBy} characters';
		$expectedParams = ['length' => 3, 'actualLength' => 4, 'exceededBy' => 1];
		self::assertEquals([new ValidationResultMessage($expectedMessage, $expectedParams)], $this->validator->__invoke(['a' => ['b' => 'abcd']], ['a', 'b']));
	}
}
