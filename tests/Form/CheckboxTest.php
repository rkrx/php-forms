<?php
namespace Forms\Form;

use Forms\Common\ComponentTestCase;
use Forms\Common\FormOptions;
use Forms\Form\Common\Params;
use Forms\Form\Validation\CallbackValidator;
use Forms\Form\Validation\Result\ValidationResultMessage;
use Forms\FormElementProvider;
use Forms\TextProviders\ArrayTextProvider;

class CheckboxTest extends ComponentTestCase {
	public function testConvert() {
		// False values
		foreach(['1', 1, true] as $testValue) {
			$data = $this->getComp()->convert(['field' => ['key' => $testValue]]);
			self::assertEquals(['field' => ['key' => true]], $data);
		}

		// False values
		foreach(['', '0', []] as $testValue) {
			$data = $this->getComp()->convert(['field' => ['key' => $testValue]]);
			self::assertEquals(['field' => ['key' => false]], $data);
		}
	}

	public function testValidate() {
		$result = $this->getComp()->validate(['field' => ['key' => 1]]);
		self::assertTrue($result->isValid());
		self::assertEmpty($result->getMessages());

		$result = $this->getComp()->validate(['field' => ['key' => 0]]);
		self::assertFalse($result->isValid());
		$this->assertNotEmpty($result->getMessages());
		foreach($result as $message) {
			self::assertEquals('Checkbox is not checked', $message->getMessage());
		}
	}

	public function testRender() {
		$data = $this->getComp()->render(['field' => ['key' => 0]], true);

		$expectedData = [
			'name' => ['field', 'key'],
			'title' => 'Field-Title',
			'value' => 0,
			'valid' => false,
			'messages' => [new ValidationResultMessage('Checkbox is not checked', [])],
			'attributes' => ['test' => 'abc'],
			'type' => 'checkbox'
		];

		self::assertEquals($expectedData, $data);
	}

	protected function getComp(): Checkbox {
		$comp = $this->getFormElementProvider()->checkbox(['field', 'key'], 'Field-Title', ['test' => 'abc']);
		$comp->addValidator(new CallbackValidator(fn (Params $params) => ($params->isScalar() && (bool) $params->getValue()) ? [] : ['Checkbox is not checked']));
		return $comp;
	}
}
