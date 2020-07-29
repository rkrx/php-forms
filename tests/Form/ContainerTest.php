<?php
namespace Forms\Form;

use Forms\Form\Abstractions\AbstractContainerElement;
use Forms\Form\Validation\IsRequired;
use Forms\Form\Validation\Result\ValidationResultMessage;
use PHPUnit\Framework\TestCase;

class ContainerTest extends TestCase {
	private AbstractContainerElement $comp;

	public function setUp(): void {
		$this->comp = new Container(['type' => 'is-container'],
			new Container([],
				(new Input(['root', 'a'], 'Test input', []))
					->addValidator(new IsRequired)
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
		$result = $this->comp->validate(['root' => ['a' => 'Test']]);
		self::assertTrue($result->isValid());
		$this->assertEmpty($result->getResults());


		$result = $this->comp->validate(['root' => ['a' => '']]);
		self::assertFalse($result->isValid());
		$this->assertCount(1, $result->getResults());
		foreach($result->getResults() as $elResult) {
			$this->assertCount(1, $elResult->getMessages());
			foreach($elResult->getMessages() as $message) {
				self::assertEquals('Input required', $message->getMessage());
				self::assertEmpty($message->getArgs());
			}
			self::assertEquals('Test input', $elResult->getElement()->getCaption());
		}
	}

	public function testRender() {
		$actualData = $this->comp->render(['root' => ['a' => '']], true);
		$expectedData = [
			'type' => 'container',
			'attributes' => ['type' => 'is-container'],
			'valid' => false,
			'elements' => [[
				'type' => 'container',
				'attributes' => [],
				'valid' => false,
				'elements' => [[
					'name' => ['root', 'a'],
                    'title' => 'Test input',
                    'value' => '',
                    'valid' => false,
                    'messages' => [new ValidationResultMessage('Input required', [])],
                    'attributes' => ['required' => true],
                    'type' => 'input'
				]]
			]]
		];

		self::assertEquals($expectedData, $actualData);
	}
}
