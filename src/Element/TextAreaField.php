<?php
namespace Kir\Forms\Element;

use Kir\Forms\AbstractNamedElement;
use Kir\Forms\Validation\ValidatorAwareTrait;

class TextAreaField extends AbstractNamedElement {
	use ValidatorAwareTrait;

	/**
	 * @param string $fieldName
	 */
	public function __construct($fieldName) {
		parent::__construct('text', $fieldName);
	}
}