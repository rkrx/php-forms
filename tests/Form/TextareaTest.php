<?php
namespace Forms\Form;

use Forms\Common\ComponentTestCase;
use Forms\Form\Filtering\TrimFilter;
use Forms\Form\Validation\Required;
use Forms\Form\Validation\Result\ValidationResultMessage;

class TextareaTest extends ComponentTestCase {
	public function testConvert() {
		$data = $this->getComp()->convert(['a' => ['b' => '   s  ']]);
		self::assertEquals('s', $data['a']['b'] ?? null);

		$data = $this->getComp()->convert(['a' => ['b' => []]]);
		self::assertEquals(null, $data['a']['b'] ?? null);
	}

	public function testValidate() {
		$result = $this->getComp()->validate(['a' => ['b' => 'test']]);
		self::assertTrue($result->isValid());
		$this->assertEmpty($result->getMessages());

		$result = $this->getComp()->validate(['a' => ['c' => 'test']]);
		self::assertFalse($result->isValid());
		$this->assertNotEmpty($result->getMessages());
	}

	public function testRender() {
		self::assertEq($this->getComp()->render(['a' => ['b' => 'test']], true), [
			'name' => ['a', 'b'],
			'title' => 'Field-Title',
			'value' => 'test',
			'valid' => true,
			'messages' => [],
			'attributes' => [
				'test' => 'abc',
				'required' => true,
			],
			'type' => 'textarea'
		]);
	}

	public function testRenderWithValidationFailure() {
		self::assertEq($this->getComp()->render(['a' => ['b' => '']], true), [
			'name' => ['a', 'b'],
			'title' => 'Field-Title',
			'value' => '',
			'valid' => false,
			'messages' => [new ValidationResultMessage('Input required')],
			'attributes' => [
				'test' => 'abc',
				'required' => true,
			],
			'type' => 'textarea'
		]);
	}

	protected function getComp(): Textarea {
		$comp = $this->getFormElementProvider()->textarea(['a', 'b'], 'Field-Title', ['test' => 'abc']);
		$comp->addFilter(new TrimFilter);
		$comp->addValidator(new Required);
		return $comp;
	}
}
