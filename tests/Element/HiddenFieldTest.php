<?php
namespace Kir\Forms\Element;

use Kir\Forms\Element;
use Kir\Forms\Validation\Contraints;

class HiddenFieldTest extends \PHPUnit_Framework_TestCase {
	public function testRender() {
		$el = (new Element\HiddenField('id', 'ID'))
		->addValidator(new Contraints\MinLengthValidator(5));

		$data = $el->render(['id' => 1234], true);

		$this->assertEquals('hiddenfield', $data['type']);
		$this->assertEquals(['id'], $data['name']);
		$this->assertEquals('1234', $data['value']);
		$this->assertEquals(false, $data['valid']);
		$this->assertEquals('ID', $data['title']);
		$this->assertEquals(['Your input is shorter (4 chars) than allowed (5 chars)'], $data['messages']);
		$this->assertEquals(['type' => 'minlength', 'message' => 'Your input is shorter ({actuallength} chars) than allowed ({minlength} chars)'], $data['validation']['minlength']);
	}
}
