<?php
namespace Kir\Forms\Validation\Contraints;

use Kir\Forms\Validation\AbstractValidator;

class EmailAddressValidator extends AbstractValidator {
	public function __construct($message = null, $standardMessage = 'The provided input is not valid') {
		parent::__construct($message, $standardMessage);
		$this->setType('email');
	}

	/**
	 * @param int|float|string $value
	 * @return bool
	 */
	protected function doValidate($value) {
		return filter_var($value, FILTER_VALIDATE_EMAIL) !== false;
	}
}