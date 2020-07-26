<?php
namespace Forms\Form\Validation;

use Forms\Form\Common\Params;
use Forms\Form\Validation\Result\ValidationResultMessage;
use PHPUnit\Framework\TestCase;

class CallbackValidatorTest extends TestCase {
	private CallbackValidator $validator;

	public function setUp(): void {
		$this->validator = new CallbackValidator(fn (Params $params) => strtolower($params->getString()) === $params->getString() ? null : 'Failed');
	}

	public function testRender() {
		self::assertEquals(['xxx' => 123], $this->validator->render(['xxx' => 123]));
	}

	public function testSuccessfulInvoke() {
		self::assertEmpty($this->validator->__invoke(['a' => ['b' => 'abc']], ['a', 'b']));
	}

	public function testFailingInvokeReturningAString() {
		self::assertEquals([new ValidationResultMessage('Failed')], $this->validator->__invoke(['a' => ['b' => 'Abc']], ['a', 'b']));
	}

	public function testFailingInvokeReturningAnValidationMessageObject() {
		$validator = new CallbackValidator(fn (Params $params) => strtolower($params->getString()) === $params->getString() ? null : new ValidationResultMessage('Failed'));
		self::assertEquals([new ValidationResultMessage('Failed')], $validator->__invoke(['a' => ['b' => 'Abc']], ['a', 'b']));
	}
}
