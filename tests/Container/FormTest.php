<?php
namespace Kir\Forms\Container;

use Kir\Forms\Validation\CollectionConstraints\MinCountValidator;

class FormTest extends \PHPUnit_Framework_TestCase {
	public function testBuild() {
		$el = (new Form());
		$el->addValidator(new MinCountValidator());
		$node = $el->build();
		$this->assertEquals('form', $node->getType());
		$this->assertEquals(null, $node->getName());
		$this->assertEquals([], $node->getPath());
		$this->assertEquals(null, $node->getValue());
		$this->assertInstanceOf(MinCountValidator::class, $node->getValidators()[0]);
	}
}
