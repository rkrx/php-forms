<?php
namespace Kir\Forms\Validation\Contraints;

use Kir\Forms\Validation\Validator;

class IntegerValidator implements Validator {
	/**
	 * @param string $value
	 * @param string|null $message
	 * @return string[]
	 */
	public function validate($value, $message = null) {
		if($message === null) {
			$message = "The provided value is a valid integer";
		}
		if(!filter_var($value, FILTER_VALIDATE_INT)) {
			return [$message];
		}
		return [];
	}
}