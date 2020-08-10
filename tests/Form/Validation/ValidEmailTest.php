<?php
namespace Forms\Form\Validation;

use Forms\Form\Validation\Result\ValidationResultMessage;
use PHPUnit\Framework\TestCase;

class ValidEmailTest extends TestCase {
	private ValidEmail $validator;

	public function setUp(): void {
		$this->validator = new ValidEmail();
	}

	public function testRender() {
		self::assertEquals(['xxx' => 123], $this->validator->render(['xxx' => 123]));
	}

	public function testSuccessfulInvoke() {
		self::assertEmpty($this->validator->__invoke(['a' => ['b' => 'max@test.dev']], ['a', 'b']));
	}

	public function testFailingInvoke() {
		self::assertEquals([new ValidationResultMessage('Invalid email address pattern')], $this->validator->__invoke(['a' => ['b' => 'max(at)test.dev']], ['a', 'b']));
	}
}
