<?php
namespace Kir\Forms\Element;

use Kir\Forms\AbstractNamedElement;

class HiddenField extends AbstractNamedElement {
	/**
	 * @param string $fieldName
	 */
	public function __construct($fieldName) {
		parent::__construct('hidden', $fieldName);
	}
}