<?php
namespace Kir\Forms;

use Kir\Forms\Nodes\Node;

interface Element {
	/**
	 * @return Node
	 */
	public function build();
}