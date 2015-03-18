<?php
namespace Kir\Forms\Validation\Contraints;

use Kir\Forms\Validation\Validator;

class EmailAddressValidator implements Validator {
	/**
	 * @param string $value
	 * @param string|null $message
	 * @return string[]
	 */
	public function validate($value, $message = null) {
		if($message === null) {
			$message = "The email address is not valid";
		}
		if(!filter_var($value, FILTER_VALIDATE_EMAIL)) {
			return [$message];
		}
		return [];
	}
}