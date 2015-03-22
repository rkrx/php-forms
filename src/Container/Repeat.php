<?php
namespace Kir\Forms\Container;

use Kir\Forms\AbstractContainer;
use Kir\Forms\Nodes\Node;

class Repeat extends AbstractContainer {
	/**
	 * @param array|string $name
	 */
	function __construct($name) {
		parent::__construct('repeat', $name);
	}

	/**
	 * @return Node
	 */
	public function build() {
		$node = parent::build();
		$node->setAttribute('repeating', true);
		return $node;
	}
}