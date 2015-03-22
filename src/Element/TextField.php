<?php
namespace Kir\Forms\Element;

use Kir\Forms\AbstractTextField;
use Kir\Forms\Misc\Data;
use Kir\Forms\Nodes\Node;

class TextField extends AbstractTextField {
	public function __construct($fieldPath, $title) {
		parent::__construct('textfield', $fieldPath);
		$this->setTitle($title);
	}

	/**
	 * @param array|Data $data
	 * @return array
	 */
	public function convert($data) {
		$data = parent::convert($data);
		return $data;
	}

	/**
	 * @return Node
	 */
	public function build() {
	}
}