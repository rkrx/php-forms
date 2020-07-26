<?php
namespace Forms\Form;

use PHPUnit\Framework\TestCase;

class SubmitTest extends TestCase {
	private Submit $comp;

	public function setUp(): void {
		$this->comp = new Submit(['a', 'b'], 'Submit', 'action', ['xyz' => 123]);
	}

	public function testConvert() {
		self::assertEquals(['x' => 'y', 'a' => ['b' => 'action']], $this->comp->convert(['x' => 'y', 'a' => ['b' => 'action']]));
	}

	public function testValidate() {
		self::assertTrue($this->comp->validate(['x' => 'y', 'a' => ['b' => 'action']])->isValid());
		self::assertEmpty($this->comp->validate(['x' => 'y', 'a' => ['b' => 'action']])->getMessages());
	}

	public function testRender() {
		$data = [
			'name' => ['a', 'b'],
			'title' => 'Submit',
			'value' => 'action',
			'messages' => [],
			'attributes' => ['xyz' => 123],
			'type' => 'submit'
		];
		self::assertEquals($data, $this->comp->render(['x' => 'y', 'a' => ['b' => 'action']]));
	}
}
