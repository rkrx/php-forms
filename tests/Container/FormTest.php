<?php
namespace Kir\Forms\Container;

class FormTest extends \PHPUnit_Framework_TestCase {
	public function testRender() {
		$el = (new Form());
		$data = $el->render(['test' => 123]);
		$this->assertEquals('form', $data['type']);
		$this->assertEquals(true, $data['valid']);
		$this->assertEquals([], $data['children']);
		$this->assertEquals([], $data['validationMessages']);
	}
}
