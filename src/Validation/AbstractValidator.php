<?php
namespace Kir\Forms\Validation;

abstract class AbstractValidator implements Validator {
	/** @var null|string */
	private $message;
	/** @var string */
	private $standardMessage;
	/** @var string */
	private $type = 'unknown';

	/**
	 * @param string|null $message
	 * @param string $standardMessage
	 */
	public function __construct($message = null, $standardMessage = 'The provided input is not valid') {
		$this->message = $message;
		$this->standardMessage = $standardMessage;
	}

	/**
	 * @return string
	 */
	protected function getType() {
		return $this->type;
	}

	/**
	 * @param string $type
	 * @return $this
	 */
	protected function setType($type) {
		$this->type = $type;
		return $this;
	}

	/**
	 * @return null|string
	 */
	public function getMessage() {
		$message = $this->message;
		if($message === null) {
			$message = $this->standardMessage;
		}
		return $message;
	}

	/**
	 * @param null|string $message
	 * @return $this
	 */
	public function setMessage($message) {
		$this->message = $message;
		return $this;
	}

	/**
	 * @param int|float|string $value
	 * @return string[]
	 */
	public function validate($value) {
		$message = $this->getMessage();
		if(!$this->doValidate($value)) {
			return [$message];
		}
		return [];
	}

	/**
	 * @return array
	 */
	public function asArray() {
		return [
			'type' => $this->type,
			'message' => $this->getMessage()
		];
	}

	/**
	 * @param int|float|string $value
	 * @return bool
	 */
	abstract protected function doValidate($value);
}