<?php
namespace Forms\Form;

use Forms\Common\ComponentTestCase;
use Forms\Form\Filtering\TrimFilter;
use Forms\Form\Validation\IsNonEmptyString;
use Forms\Form\Validation\Result\ValidationResultMessage;

class InputTest extends ComponentTestCase {
	public function testConvert() {
		$data = $this->getComp()->convert(['a' => ['b' => '   s  ']]);
		self::assertEquals('s', $data['a']['b'] ?? null);

		$data = $this->getComp()->convert(['a' => ['b' => []]]);
		self::assertEquals(null, $data['a']['b'] ?? null);
	}

	public function testValidate() {
		$result = $this->getComp()->validate(['a' => ['b' => 'test']]);
		self::assertEquals(true, $result->isValid());
		$this->assertEmpty($result->getMessages());

		$result = $this->getComp()->validate(['a' => ['c' => 'test']]);
		self::assertEquals(false, $result->isValid());
		$this->assertNotEmpty($result->getMessages());
	}

	public function testRender() {
		self::assertEq($this->getComp()->render(['a' => ['b' => 'test']], true), [
			'name' => ['a', 'b'],
			'title' => 'Field-Title',
			'value' => 'test',
			'messages' => [],
			'attributes' => [
				'test' => 'abc',
				'required' => true,
			],
			'type' => 'input'
		]);
	}

	public function testRenderWithValidationFailure() {
		self::assertEq($this->getComp()->render(['a' => ['b' => '']], true), [
			'name' => ['a', 'b'],
			'title' => 'Field-Title',
			'value' => '',
			'messages' => [new ValidationResultMessage('Input required')],
			'attributes' => [
				'test' => 'abc',
				'required' => true,
			],
			'type' => 'input'
		]);
	}

	protected function getComp(): Input {
		$comp = $this->getFormElementProvider()->input(['a', 'b'], 'Field-Title', ['test' => 'abc']);
		$comp->addFilter(new TrimFilter);
		$comp->addValidator(new IsNonEmptyString);
		return $comp;
	}
}
