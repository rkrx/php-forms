<?php
namespace Kir\Forms\Validation;

class ValidationResult {
	/** @var string[] */
	private $errorMessages = [];

	/**
	 * @param $message
	 * @return $this
	 */
	public function addErrorMessage($message) {
		$this->errorMessages[] = $message;
		return $this;
	}

	/**
	 * @return int
	 */
	public function hasErrorMessages() {
		return count($this->errorMessages) > 0;
	}

	/**
	 * @return string[]
	 */
	public function getErrorMessages() {
		return $this->errorMessages;
	}
}