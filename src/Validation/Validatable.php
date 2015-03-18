<?php
namespace Kir\Forms\Validation;


interface Validatable {
	/**
	 * @param array $data
	 * @return ValidationResult
	 */
	public function validate(array $data);
}