<?php
namespace Kir\Forms\Decorators;

use Kir\Forms\Nodes\Node;

class ValidationDecorator {
	/**
	 * @param Node $node
	 */
	public function decorate(Node $node) {
		$validators = $node->getValidators();
		$value = $node->getValue();
		foreach($validators as $validator) {
			$messages = $validator->validate($value, $node);
			foreach($messages as $message) {
				$node->addMessage($message);
			}
		}
		foreach($node->getNodes() as $childNode) {
			$this->decorate($childNode);
		}
	}
}