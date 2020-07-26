<?php
namespace Forms\Form\Validation;

use Forms\Form\Validation\Result\ValidationResultMessage;
use PHPUnit\Framework\TestCase;

class IsNonEmptyStringTest extends TestCase {
	private IsNonEmptyString $validator;

	public function setUp(): void {
		$this->validator = new IsNonEmptyString();
	}

	public function testRender() {
		self::assertEquals(['xxx' => 123, 'attributes' => ['required' => true]], $this->validator->render(['xxx' => 123]));
	}

	public function testSuccessfulInvoke() {
		self::assertEmpty($this->validator->__invoke(['a' => ['b' => 'test']], ['a', 'b']));
	}

	public function testFailingInvoke() {
		self::assertEquals([new ValidationResultMessage('Input required')], $this->validator->__invoke(['a' => ['b' => '']], ['a', 'b']));
	}
}
