<?php
namespace Forms\Form\Validation;

use Forms\Form\Common\Params;
use Forms\Form\Validation\Result\ValidationResultMessage;
use PHPUnit\Framework\TestCase;

class BooleanCallbackValidatorTest extends TestCase {
	private BooleanCallbackValidator $validator;

	public function setUp(): void {
		$noSpaces = fn(string $s) => preg_replace('/\\P{L}+/', '', strtolower($s));
		$this->validator = new BooleanCallbackValidator(fn (Params $s) => strrev($noSpaces($s->getString())) === $noSpaces($s->getString()), 'Input is not a palindrome.', fn () => []);
	}

	public function testRender() {
		self::assertEquals(['xxx' => 123], $this->validator->render(['xxx' => 123]));
	}

	public function testSuccessfulInvoke() {
		self::assertEmpty($this->validator->__invoke(['a' => ['b' => 'Are we not pure? "No, sir!" Panama\'s moody Noriega brags. "It is garbage!" Irony dooms a man-a prisoner up to new era.']], ['a', 'b']));
	}

	public function testFailingInvoke() {
		$msg = 'Input is not a palindrome.';
		self::assertEquals([new ValidationResultMessage($msg, [])], $this->validator->__invoke(['a' => ['b' => 'hello world']], ['a', 'b']));
	}
}
