<?php
namespace Kir\Forms\Element;

use Kir\Forms\AbstractTextField;

class TextField extends AbstractTextField {
	public function __construct($fieldPath, $title) {
		parent::__construct($fieldPath, $title);
		$this->setType('textfield');
	}
}