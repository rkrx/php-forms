<?php
namespace Kir\Forms\Decorators;

use Kir\Forms\Nodes\Node;

class DataDecoratorTest extends \PHPUnit_Framework_TestCase {
	public function test() {
		$data = [
			'name' => 'Max Mustermann',
			'company' => 'Acme',
		];
		$node = new Node('container', null);
		$node->addNode(new Node('textfield', 'name'));
		$node->addNode(new Node('textfield', 'company'));
		$dataDecorator = new DataDecorator();
		$dataDecorator->decorate($data, $node);

		$this->assertEquals('Max Mustermann', $node->getNodes()[0]->getValue());
		$this->assertEquals('Acme', $node->getNodes()[1]->getValue());
	}
}
