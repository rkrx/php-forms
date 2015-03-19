<?php
namespace Kir\Forms\Element;

use Kir\Forms\AbstractTextField;

class TextAreaField extends AbstractTextField {
	/**
	 * @param string $fieldPath
	 * @param string $title
	 */
	public function __construct($fieldPath, $title) {
		parent::__construct($fieldPath, $title);
		$this->setType('textareafield');
	}
}