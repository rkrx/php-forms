<?php

namespace Forms\Form\Validation\Result;

use ArrayIterator;
use Forms\Form\Abstractions\AbstractInput;
use Traversable;

class ElementValidationResult implements ValidationResult {
	private AbstractInput $element;
	/** @var ValidationResultMessage[] */
	private array $messages;

	/**
	 * @param AbstractInput $element
	 * @param ValidationResultMessage ...$messages
	 */
	public function __construct(AbstractInput $element, ValidationResultMessage ...$messages) {
		$this->element = $element;
		$this->messages = $messages;
	}

	/**
	 * @return AbstractInput
	 */
	public function getElement(): AbstractInput {
		return $this->element;
	}

	/**
	 * @return bool
	 */
	public function isValid(): bool {
		return count($this->messages) < 1;
	}

	/**
	 * @return ValidationResultMessage[]
	 */
	public function getMessages(): array {
		return $this->messages;
	}

	/**
	 * @return string
	 */
	public function __toString(): string {
		$result = [];
		foreach($this->messages as $message) {
			$result[] = (string) $message;
		}
		return implode("\n", $result);
	}

	/**
	 * @return Traversable|ValidationResultMessage[]
	 */
	public function getIterator() {
		return new ArrayIterator($this->messages);
	}

	/**
	 * @return array[]
	 */
	public function jsonSerialize() {
		$messages = [];
		foreach($this->messages as $message) {
			$messages[] = [
				'message' => $message->getMessage(),
				'args' => $message->getArgs(),
				'template' => $message->getMessageTemplate(),
			];
		}
		return [
			'messages' => $messages,
		];
	}
}
