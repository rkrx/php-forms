<?php
namespace Forms\Form\Validation\Result;

use JsonSerializable;

class ValidationResultMessage implements JsonSerializable {
	private string $message;
	private array $args;

	public function __construct(string $message, array $args = []) {
		$this->message = $message;
		$this->args = $args;
	}

	public function getMessage(): string {
		$substitutes = [];
		foreach($this->args as $key => $value) {
			$key = '{'.$key.'}';
			$substitutes[$key] = $value;
		}
		return strtr($this->message, $substitutes);
	}

	public function getMessageTemplate(): string {
		return $this->message;
	}

	public function getArgs(): array {
		return $this->args;
	}

	public function __toString(): string {
		return $this->getMessage();
	}

	public function jsonSerialize() {
		return ['message' => $this->message, 'args' => $this->args];
	}
}
