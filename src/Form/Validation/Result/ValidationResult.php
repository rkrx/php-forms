<?php

namespace Forms\Form\Validation\Result;

interface ValidationResult {
	/**
	 * @return bool
	 */
	public function isValid(): bool;
	
	/**
	 * @return string
	 */
	public function __toString(): string;
}
