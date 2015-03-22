<?php
namespace Kir\Forms\Decorators;

use Kir\Forms\Nodes\Node;

class DataDecorator {
	/**
	 * @param int|float|string|array $data
	 * @param Node $node
	 */
	public function decorate($data, Node $node) {
		$value = $data;
		$fieldName = $node->getName();
		if($fieldName !== null) {
			$value = null;
			if(array_key_exists($fieldName, $data)) {
				$value = $data[$fieldName];
			}
			$node->setValue($value);
		}
		foreach($node->getNodes() as $childNode) {
			if($node->getAttribute('repeating')) {
			}
			$this->decorate($value, $childNode);
		}
	}
}