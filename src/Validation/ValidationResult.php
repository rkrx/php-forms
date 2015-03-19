<?php
namespace Kir\Forms\Validation;

class ValidationResult {
	/** @var string[] */
	private $errorMessages = [];
	/** @var bool */
	private $hasInnerErrors = false;

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

	/**
	 * @return boolean
	 */
	public function hasInnerErrors() {
		return $this->hasInnerErrors;
	}

	/**
	 * @param boolean $hasInnerErrors
	 * @return $this
	 */
	public function setHasInnerErrors($hasInnerErrors) {
		$this->hasInnerErrors = $hasInnerErrors;
		return $this;
	}
}