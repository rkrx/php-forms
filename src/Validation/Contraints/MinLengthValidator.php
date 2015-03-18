<?php
namespace Kir\Forms\Validation\Contraints;

use Kir\Forms\Validation\Validator;

class MinLengthValidator implements Validator {
	/** @var int */
	private $minLength;
	/** @var string */
	private $encoding;

	/**
	 * @param int $minLength
	 * @param string $encoding
	 */
	public function __construct($minLength, $encoding = 'UTF-8') {
		$this->minLength = $minLength;
		$this->encoding = $encoding;
	}

	/**
	 * @param string $value
	 * @param string|null $message
	 * @return string[]
	 */
	public function validate($value, $message = null) {
		if($message === null) {
			$message = "Your input is shorter ({actuallength} chars) than allowed ({maxlength} chars)";
		}
		$actualLength = mb_strlen($value, $this->encoding);
		if($actualLength < $this->minLength) {
			$message = strtr($message, ['{minlength}' => $this->minLength, '{actuallength}' => $actualLength]);
			return [$message];
		}
		return [];
	}
}