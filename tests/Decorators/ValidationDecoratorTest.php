<?php
namespace Kir\Forms\Decorators;

use Kir\Forms\Nodes\Node;
use Kir\Forms\Validation\Contraints\MaxLengthValidator;
use Kir\Forms\Validation\Contraints\MinLengthValidator;

class ValidationDecoratorTest extends \PHPUnit_Framework_TestCase {
	public function test() {
		$data = [
			'name' => 'Max Mustermann',
			'company' => 'Acme',
		];
		$node = new Node('container', null);
		$node->addNode(
			(new Node('textfield', 'name'))
			->addValidator(new MinLengthValidator(3, 'Name is too short'))
			->addValidator(new MaxLengthValidator(10, 'Name is too long'))
		);
		$node->addNode(
			(new Node('textfield', 'company'))
			->addValidator(new MinLengthValidator(3, 'Name is too short'))
			->addValidator(new MaxLengthValidator(10, 'Name is too long'))
		);
		$dataDecorator = new ValidationDecorator();
		$dataDecorator->decorate($node);

		print_r($node);

		#$this->assertEquals('Max Mustermann', $node->getNodes()[0]->getValue());
		#$this->assertEquals('Acme', $node->getNodes()[1]->getValue());
	}
}
