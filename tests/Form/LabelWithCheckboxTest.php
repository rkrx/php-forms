<?php
namespace Forms\Form;

use Forms\Form\Filtering\TrimFilter;
use Forms\Form\Validation\IsRequired;
use Forms\Form\Validation\IsValidEmail;
use Forms\Form\Validation\Result\ValidationResultMessage;
use PHPUnit\Framework\TestCase;

class LabelWithCheckboxTest extends TestCase {
	private LabelWithCheckbox $comp;

	public function setUp(): void {
		parent::setUp();
		$this->comp = new LabelWithCheckbox(['a', 'b'], 'Title', ['some-attribute' => 'some-value'],
			(new Input(['a', 'c'], 'Field-Title', ['test' => 'abc']))
				->addFilter(new TrimFilter)
				->addValidator(new IsValidEmail())
				->addValidator(new IsRequired())
		);
	}

	public function testConvert() {
		$data = $this->comp->convert(['a' => ['c' => '   john.doe@example.org   ']]);
		self::assertEquals(['a' => ['c' => 'john.doe@example.org']], $data);
	}

	public function testConvertWithNullValue() {
		$data = $this->comp->convert([]);
		self::assertEquals(['a' => ['c' => null]], $data);
	}

	public function testValidate() {
		$result = $this->comp->validate(['a' => ['c' => 'john.doe@example.org']]);
		self::assertTrue($result->isValid());
	}

	public function testValidateFailure() {
		$result = $this->comp->validate([]);
		self::assertFalse($result->isValid());
	}

	public function testRender() {
		$data = $this->comp->render(['a' => ['c' => 'john.doe@example.org']], true);

		$expected = [
			'type' => 'label-with-checkbox',
			'elements' => [[
				'name' => ['a', 'c'],
				'title' => 'Field-Title',
				'value' => 'john.doe@example.org',
				'valid' => true,
				'messages' => [],
				'attributes' => ['test' => 'abc', 'required' => true],
				'type' => 'input',
			]],
			'attributes' => ['some-attribute' => 'some-value'],
			'title' => 'Title',
			'valid' => true,
			'checkbox' => [
				'name' => ['a', 'b'],
				'title' => 'Title',
				'value' => null,
				'valid' => true,
				'messages' => [],
				'attributes' => [],
				'type' => 'checkbox'
			],
		];

		self::assertEquals($expected, $data);
	}

	public function testRenderWithNegativeValidationResult() {
		$data = $this->comp->render(['a' => ['c' => 'john.doe-at-example.org']], true);

		$expected = [
			'type' => 'label-with-checkbox',
			'elements' => [[
				'name' => ['a', 'c'],
				'title' => 'Field-Title',
				'value' => 'john.doe-at-example.org',
				'valid' => false,
				'messages' => [new ValidationResultMessage('Invalid email address pattern', [])],
				'attributes' => ['test' => 'abc', 'required' => true],
				'type' => 'input',
			]],
			'attributes' => ['some-attribute' => 'some-value'],
			'valid' => false,
			'title' => 'Title',
			'checkbox' => [
				'name' => ['a', 'b'],
				'title' => 'Title',
				'value' => null,
				'valid' => true,
				'messages' => [],
				'attributes' => [],
				'type' => 'checkbox'
			],
		];

		self::assertEquals($expected, $data);
	}
}
