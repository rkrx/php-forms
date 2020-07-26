<?php
namespace Forms\Form\Common;

class InvalidValue {
	/** @var mixed */
	private $value;
	private array $attributes;

	public function __construct($value = null, array $attributes = []) {
		$this->value = $value;
		$this->attributes = $attributes;
	}

	public function getValue() {
		return $this->value;
	}

	public function getAttributes(): array {
		return $this->attributes;
	}

	public function __toString(): string {
		if(!is_scalar($this->value)) {
			return '';
		}
		return (string) $this->value;
	}
}
