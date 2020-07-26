<?php
namespace Forms\Form;

use Forms\Form\Abstractions\AbstractContainerElement;
use Forms\Form\Common\Params;
use Forms\Form\Validation\CallbackValidator;
use Forms\Form\Validation\Result\ValidationResultMessage;
use PHPUnit\Framework\TestCase;

class ContainerTest extends TestCase {
	private AbstractContainerElement $comp;

	public function setUp(): void {
		$this->comp = new Container(['type' => 'is-container'],
			new Container([],
				(new Checkbox(['root', 'a'], 'Test checkbox', []))
					->addValidator(new CallbackValidator(fn (Params $params) => ($params->isScalar() && (bool) $params->getValue()) ? [] : ['Checkbox is not checked']))
			)
		);
	}

	public function testConvert() {
		$data = $this->comp->convert(['root' => ['a' => 1]]);
		self::assertEquals(['root' => ['a' => true]], $data);

		$data = $this->comp->convert(['root' => ['a' => '']]);
		self::assertEquals(['root' => ['a' => false]], $data);
	}

	public function testValidate() {
		$result = $this->comp->validate(['root' => ['a' => 1]]);
		self::assertTrue($result->isValid());
		$this->assertEmpty($result->getResults());


		$result = $this->comp->validate(['root' => ['a' => 0]]);
		self::assertFalse($result->isValid());
		$this->assertCount(1, $result->getResults());
		foreach($result->getResults() as $elResult) {
			$this->assertCount(1, $elResult->getMessages());
			foreach($elResult->getMessages() as $message) {
				self::assertEquals('Checkbox is not checked', $message->getMessage());
				self::assertEmpty($message->getArgs());
			}
			self::assertEquals('Test checkbox', $elResult->getElement()->getCaption());
		}
	}

	public function testRender() {
		$actualData = $this->comp->render(['root' => ['a' => 0]], true);
		$expectedData = [
			'type' => 'container',
			'attributes' => ['type' => 'is-container'],
			'elements' => [[
				'type' => 'container',
				'attributes' => [],
				'elements' => [[
					'name' => ['root', 'a'],
                    'title' => 'Test checkbox',
                    'value' => 0,
                    'messages' => [new ValidationResultMessage('Checkbox is not checked', [])],
                    'attributes' => [],
                    'type' => 'checkbox'
				]]
			]]
		];

		self::assertEquals($expectedData, $actualData);
	}
}
