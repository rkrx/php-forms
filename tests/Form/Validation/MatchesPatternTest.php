<?php
namespace Forms\Form\Validation;

use PHPUnit\Framework\TestCase;

class MatchesPatternTest extends TestCase {
	private MatchesPattern $validator;

	public function setUp(): void {
		$this->validator = new MatchesPattern('/^\\d+$/');
	}

	public function testRender() {
		self::assertEquals(['xxx' => 123, 'attributes' => ['pattern' => '^\d+$']], $this->validator->render(['xxx' => 123]));
	}

	public function testSuccessfulInvoke() {
		self::assertEmpty($this->validator->__invoke(['xxx' => 123], ['xxx']));
	}

	public function testFailingInvoke() {
		self::assertNotEmpty($this->validator->__invoke(['xxx' => 12.3], ['xxx']));
	}
}
