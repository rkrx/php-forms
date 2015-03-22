<?php
namespace Kir\Forms\Element;

use Kir\Forms\AbstractTextField;
use Kir\Forms\Nodes\Node;

class TextField extends AbstractTextField {
	public function __construct($fieldPath, $title) {
		parent::__construct($fieldPath, $title);
		$this->setType('textfield');
	}

	/**
	 * @return Node
	 */
	public function build() {
		// TODO: Implement build() method.
	}
}