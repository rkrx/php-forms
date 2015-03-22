<?php
namespace Kir\Forms\Container;

class RepeatTest extends \PHPUnit_Framework_TestCase {
	public function test() {
		$repeater = new Repeat('test');
		$node = $repeater->build();
		$data = $node->asArray();
		print_r($data);
	}
}
