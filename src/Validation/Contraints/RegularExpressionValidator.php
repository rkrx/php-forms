<?php
namespace Kir\Forms\Validation\Contraints;

use Kir\Forms\Validation\Validator;

class RegularExpressionValidator implements Validator {
	/** @var int */
	private $regexp;
	/** @var string */
	private $encoding;

	/**
	 * @param int $regexp
	 * @param string $encoding
	 */
	public function __construct($regexp, $encoding = 'UTF-8') {
		$this->regexp = $regexp;
		$this->encoding = $encoding;
	}

	/**
	 * @param string $value
	 * @param string|null $message
	 * @return string[]
	 */
	public function validate($value, $message = null) {
		if($message === null) {
			$message = "Your input is not valid";
		}
		if(!preg_match($this->regexp, (string) $value)) {
			return [$message];
		}
		return [];
	}
}