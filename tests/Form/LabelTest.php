<?php
namespace Forms\Form;

use Forms\Form\Filtering\TrimFilter;
use Forms\Form\Validation\Required;
use Forms\Form\Validation\ValidEmail;
use Forms\Form\Validation\Result\ValidationResultMessage;
use PHPUnit\Framework\TestCase;

class LabelTest extends TestCase {
	private Label $comp;

	public function setUp(): void {
		parent::setUp();
		$this->comp = new Label('Title', ['some-attribute' => 'some-value'],
			(new Input(['a', 'b'], 'Field-Title', ['test' => 'abc']))
				->addFilter(new TrimFilter)
				->addValidator(new ValidEmail())
				->addValidator(new Required())
		);
	}

	public function testConvert() {
		$data = $this->comp->convert(['a' => ['b' => '   john.doe@example.org   ']]);
		self::assertEquals(['a' => ['b' => 'john.doe@example.org']], $data);
	}

	public function testConvertWithNullValue() {
		$data = $this->comp->convert([]);
		self::assertEquals(['a' => ['b' => null]], $data);
	}

	public function testValidate() {
		$result = $this->comp->validate(['a' => ['b' => 'john.doe@example.org']]);
		self::assertTrue($result->isValid());
	}

	public function testValidateMissingKey() {
		$result = $this->comp->validate(['a' => ['c' => 'john.doe@example.org']]);
		self::assertFalse($result->isValid());
	}

	public function testValidateFailure() {
		$result = $this->comp->validate([]);
		self::assertFalse($result->isValid());
		self::assertNotEmpty($result->getResults());
	}

	public function testRender() {
		$data = $this->comp->render(['a' => ['b' => 'john.doe@example.org']], true);

		$expected = [
			'type' => 'label',
			'elements' => [[
				'name' => ['a', 'b'],
				'title' => 'Field-Title',
				'value' => 'john.doe@example.org',
				'valid' => true,
				'messages' => [],
				'attributes' => ['test' => 'abc', 'required' => true],
				'type' => 'input',
			]],
			'attributes' => ['some-attribute' => 'some-value'],
			'title' => 'Title',
			'valid' => true
		];

		self::assertEquals($expected, $data);
	}

	public function testRenderWithNegativeValidationResult() {
		$data = $this->comp->render(['a' => ['b' => 'john.doe-at-example.org']], true);

		$expected = [
			'type' => 'label',
			'elements' => [[
				'name' => ['a', 'b'],
				'title' => 'Field-Title',
				'value' => 'john.doe-at-example.org',
				'valid' => false,
				'messages' => [new ValidationResultMessage('Invalid email address pattern', [])],
				'attributes' => ['test' => 'abc', 'required' => true],
				'type' => 'input',
			]],
			'attributes' => ['some-attribute' => 'some-value'],
			'title' => 'Title',
			'valid' => false
		];

		self::assertEquals($expected, $data);
	}
}
