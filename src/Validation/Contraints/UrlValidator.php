<?php
namespace Kir\Forms\Validation\Contraints;

use Kir\Forms\Validation\AbstractValidator;

class UrlValidator extends AbstractValidator {
	/**
	 * @param string|null $message
	 */
	public function __construct($message = null) {
		parent::__construct($message);
		$this->setType('url');
	}

	/**
	 * @param int|float|string $value
	 * @return bool
	 */
	protected function doValidate($value) {
		return filter_var($value, FILTER_VALIDATE_URL) !== false;
	}
}