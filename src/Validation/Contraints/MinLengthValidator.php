<?php
namespace Kir\Forms\Validation\Contraints;

use Kir\Forms\Validation\AbstractValidator;

class MinLengthValidator extends AbstractValidator {
	/** @var int */
	private $length;
	/** @var string */
	private $encoding;

	/**
	 * @param int $length
	 * @param string $message
	 * @param string $encoding
	 */
	public function __construct($length = 1, $message = null, $encoding = 'UTF-8') {
		parent::__construct($message, 'Your input is shorter ({actuallength} chars) than allowed ({minlength} chars)');
		$this->setType('minlength');
		$this->length = $length;
		$this->encoding = $encoding;
	}

	/**
	 * @return int
	 */
	public function getLength() {
		return $this->length;
	}

	/**
	 * @param int $length
	 * @return $this
	 */
	public function setLength($length) {
		$this->length = $length;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getEncoding() {
		return $this->encoding;
	}

	/**
	 * @param string $encoding
	 * @return $this
	 */
	public function setEncoding($encoding) {
		$this->encoding = $encoding;
		return $this;
	}

	/**
	 * @param string $value
	 * @return string[]
	 */
	public function validate($value) {
		$message = $this->getMessage();
		$actualLength = mb_strlen($value, $this->encoding);
		if($actualLength < $this->length) {
			$message = strtr($message, ['{minlength}' => $this->length, '{actuallength}' => $actualLength]);
			return [$message];
		}
		return [];
	}

	/**
	 * @param int|float|string $value
	 * @return bool
	 */
	protected function doValidate($value) {
	}
}