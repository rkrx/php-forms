<?php
namespace Kir\Forms\Validation\Contraints;

use Kir\Forms\Validation\AbstractValidator;

class ClosureValidator extends AbstractValidator {
	/** @var callable */
	private $fn;

	/**
	 * @param callable $fn
	 * @param string $message
	 */
	public function __construct($fn, $message) {
		parent::__construct($message);
		$this->fn = $fn;
	}

	/**
	 * @param int|float|string $value
	 * @return bool
	 */
	protected function doValidate($value) {
		return call_user_func($this->fn, $value);
	}
}