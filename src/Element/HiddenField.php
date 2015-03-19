<?php
namespace Kir\Forms\Element;

use Kir\Forms\AbstractTextField;
use Kir\Forms\Filtering\FilterAwareTrait;
use Kir\Forms\Validation\ValidatorAwareTrait;

class HiddenField extends AbstractTextField {
	use ValidatorAwareTrait;
	use FilterAwareTrait;

	/**
	 * @param string $fieldPath
	 * @param string $title
	 */
	public function __construct($fieldPath, $title) {
		parent::__construct($fieldPath, $title);
		$this->setType('hiddenfield');
	}
}