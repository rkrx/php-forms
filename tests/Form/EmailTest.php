<?php
namespace Forms\Form;

use Forms\Common\ComponentTestCase;
use Forms\Form\Validation\Result\ValidationResultMessage;

class EmailTest extends ComponentTestCase {
	public function testConvert() {
		self::assertEquals(['a' => ['b' => 'name@test.dev']], $this->getComp()->convert(['a' => ['b' => ' name@test.dev ']]));
	}

	public function testConvertInvalidType() {
		self::assertEquals(['a' => ['b' => '']], $this->getComp()->convert(['a' => ['b' => ['c' => 'name@test.dev']]]));
	}

	public function testValidate() {
		self::assertTrue($this->convertAndValidate($this->getComp(), ['a' => ['b' => 'name@test.dev']])->isValid());
	}

	public function testValidateFailure() {
		self::assertFalse($this->convertAndValidate($this->getComp(), ['a' => ['b' => '  ']])->isValid());
	}

	public function testRender() {
		self::assertEq($this->getComp()->render(['a' => ['b' => 'name@test.dev']], true), [
			'name' => ['a', 'b'],
			'title' => 'Email',
			'value' => 'name@test.dev',
			'messages' => [],
			'attributes' => ['x' => 123],
			'type' => 'email'
		]);
	}

	public function testRenderWithError() {
		self::assertEq($this->getComp()->render(['a' => ['b' => 'xxx']], true), [
			'name' => ['a', 'b'],
			'title' => 'Email',
			'value' => 'xxx',
			'messages' => [new ValidationResultMessage('Invalid email address pattern')],
			'attributes' => ['x' => 123],
			'type' => 'email'
		]);
	}

	protected function getComp(): Email {
		return $this->getFormElementProvider()->email(['a', 'b'], 'Email', ['x' => 123]);
	}
}
