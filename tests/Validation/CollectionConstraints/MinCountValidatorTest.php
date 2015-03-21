<?php
namespace Kir\Forms\Validation\CollectionConstraints;

use Kir\Forms\Nodes\Node;

class MinCountValidatorTest extends \PHPUnit_Framework_TestCase {
	public function testSuccess() {
		$node = new Node(null, null);
		$validator = new MinCountValidator(1, 'Mindestens {count} Element(e) erwartet');
		$messages = $validator->validate(['test'], $node);
		$this->assertEquals([], $messages);
	}

	public function testFailure() {
		$node = new Node(null, null);
		$validator = new MinCountValidator(1, 'Mindestens {count} Element(e) erwartet');
		$messages = $validator->validate([], $node);
		$this->assertEquals(['Mindestens 1 Element(e) erwartet'], $messages);
	}

	public function testData() {
		$validator = new MinCountValidator(1, 'abc');
		$data = $validator->asArray();
		$this->assertEquals(['minCount' => 1, 'message' => 'abc'], $data);
	}
}
