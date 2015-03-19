<?php
namespace Kir\Forms\Validation;

interface Validator {
	/**
	 * @param int|float|string $value
	 * @return string[]
	 */
	public function validate($value);

	/**
	 * @return array
	 */
	public function asArray();
}