<?php
namespace Kir\Forms\Element;

use Kir\Forms\Element;
use Kir\Forms\Filtering\Filters;
use Kir\Forms\Validation\Contraints;

class TextFieldTest extends \PHPUnit_Framework_TestCase {
	public function testConvert() {
		$el = (new Element\TextField('name', 'Name'))
		->addFilter(new Filters\UpperCaseFilter());

		$data = $el->convert(['name' => 'Max Mustermann']);

		$this->assertEquals('MAX MUSTERMANN', $data['name']);
	}

	public function testValidate() {
		$el = (new Element\TextField('name', 'Name'))
		->addValidator(new Contraints\MinLengthValidator(20, 'Mindestend {minlength} Zeichen erwartet'));

		$result = $el->validate(['name' => 'Max Mustermann']);

		$this->assertFalse($result->hasInnerErrors());
		$this->assertTrue($result->hasErrorMessages());
		$this->assertEquals(['Mindestend 20 Zeichen erwartet'], $result->getErrorMessages());
	}

	public function testRender() {
		$el = (new Element\TextField('name', 'Name'))
		->addValidator(new Contraints\MinLengthValidator(20, 'Mindestend {minlength} Zeichen erwartet'));

		$data = $el->render(['name' => 'Jane Doe'], true);

		$this->assertEquals('textfield', $data['type']);
		$this->assertEquals(['name'], $data['name']);
		$this->assertEquals('Jane Doe', $data['value']);
		$this->assertEquals(false, $data['valid']);
		$this->assertEquals('Name', $data['title']);
		$this->assertEquals(['Mindestend 20 Zeichen erwartet'], $data['messages']);
		$this->assertEquals(['type' => 'minlength', 'message' => 'Mindestend {minlength} Zeichen erwartet'], $data['validation']['minlength']);
	}
}
