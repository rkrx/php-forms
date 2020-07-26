<?php
namespace Forms\Form\Abstractions;

use Forms\Form\Validation\Result\ValidationResult;

interface FormElement {
	/**
	 * @param array $data
	 * @return array
	 */
	public function convert(array $data): array;

	/**
	 * @param array $data
	 * @return ValidationResult
	 */
	public function validate(array $data): ValidationResult;

	/**
	 * @param array $data
	 * @param bool $validate
	 * @return array
	 */
	public function render(array $data, bool $validate = false): array;
}
