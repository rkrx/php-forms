<?php
namespace Forms\Form;

use PHPUnit\Framework\TestCase;

class SectionTest extends TestCase {
	private Section $comp;

	public function setUp(): void {
		$this->comp = new Section('Section', ['xyz' => 123],
			new Checkbox(['data', 'active'], 'Active'),
			new Input(['data', 'name'], 'Name'),
			new Email(['data', 'email'], 'Email')
		);
	}

	public function testConvert() {
		$data = $this->comp->convert(['data' => ['active' => true, 'name' => 'Jane Doe', 'email' => 'test@user.dev']]);
		self::assertEquals(['data' => ['active' => true, 'name' => 'Jane Doe', 'email' => 'test@user.dev']], $data);
	}

	public function testValidate() {
		$result = $this->comp->validate(['data' => ['active' => true, 'name' => 'Jane Doe', 'email' => 'test@user.dev']]);
		self::assertTrue($result->isValid());
		self::assertEmpty($result->getResults());
	}

	public function testValidateFailure() {
		$result = $this->comp->validate(['data' => ['active' => true, 'name' => 'Jane Doe', 'email' => 'test(at)user.dev']]);
		self::assertFalse($result->isValid());
		self::assertNotEmpty($result->getResults());
	}

	public function testRender() {
		$result = $this->comp->render(['data' => ['active' => true, 'name' => 'Jane Doe', 'email' => 'test(at)user.dev']]);
		$expected = [
			'type' => 'section',
			'elements' => [[
				'name' => ['data', 'active'],
				'title' => 'Active',
				'value' => true,
				'messages' => [],
				'attributes' => [],
				'type' => 'checkbox'
			], [
				'name' => ['data', 'name'],
				'title' => 'Name',
				'value' => 'Jane Doe',
				'messages' => [],
				'attributes' => [],
				'type' => 'input'
			], [
				'name' => ['data', 'email'],
				'title' => 'Email',
				'value' => 'test(at)user.dev',
				'messages' => [],
				'attributes' => [],
				'type' => 'email'
			]],
			'attributes' => ['xyz' => 123],
			'title' => 'Section'
		];
		self::assertEquals($expected, $result);
	}
}
