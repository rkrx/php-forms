<?php
namespace Kir\Forms\Validation\Contraints;

use Kir\Forms\Validation\Validator;

class MaxLengthValidator implements Validator {
	/** @var int */
	private $maxLength;
	/** @var string */
	private $encoding;

	/**
	 * @param int $maxLength
	 * @param string $encoding
	 */
	public function __construct($maxLength, $encoding = 'UTF-8') {
		$this->maxLength = $maxLength;
		$this->encoding = $encoding;
	}

	/**
	 * @param string $value
	 * @param string|null $message
	 * @return string[]
	 */
	public function validate($value, $message = null) {
		if($message === null) {
			$message = "Your input is longer ({actuallength} chars) than allowed ({maxlength} chars)";
		}
		$actualLength = mb_strlen($value, $this->encoding);
		if($actualLength > $this->maxLength) {
			$message = strtr($message, ['{maxlength}' => $this->maxLength, '{actuallength}' => $actualLength]);
			return [$message];
		}
		return [];
	}
}