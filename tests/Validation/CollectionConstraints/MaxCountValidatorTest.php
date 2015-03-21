<?php
namespace Kir\Forms\Validation\CollectionConstraints;

use Kir\Forms\Nodes\Node;

class MaxCountValidatorTest extends \PHPUnit_Framework_TestCase {
	public function testSuccess() {
		$node = new Node(null, null);
		$validator = new MaxCountValidator(1, 'Maximal {count} Element(e) erwartet');
		$messages = $validator->validate(['test'], $node);
		$this->assertEquals([], $messages);
	}

	public function testFailure() {
		$node = new Node(null, null);
		$validator = new MaxCountValidator(1, 'Maximal {count} Element(e) erwartet');
		$messages = $validator->validate([1, 2], $node);
		$this->assertEquals(['Maximal 1 Element(e) erwartet'], $messages);
	}

	public function testData() {
		$validator = new MaxCountValidator(1, 'abc');
		$data = $validator->asArray();
		$this->assertEquals(['maxCount' => 1, 'message' => 'abc'], $data);
	}
}
