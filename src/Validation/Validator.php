<?php
namespace Kir\Forms\Validation;

interface Validator {
	/**
	 * @param string $value
	 * @return string[]
	 */
	public function validate($value);
}