<?php
namespace Kir\Forms\Validation\Contraints;

use Kir\Forms\Validation\Validator;

class UrlValidator implements Validator {
	/**
	 * @param string $value
	 * @param string|null $message
	 * @return string[]
	 */
	public function validate($value, $message = null) {
		if($message === null) {
			$message = "The url is not valid";
		}
		if(!filter_var($value, FILTER_VALIDATE_URL)) {
			return [$message];
		}
		return [];
	}
}