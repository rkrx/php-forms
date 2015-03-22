<?php
namespace Kir\Forms\Validation;

use Exception;
use Kir\Forms\Nodes\Node;

interface Validator {
	/**
	 * @param int|float|string|array $value
	 * @return string[]
	 * @throws Exception
	 */
	public function validate($value);

	/**
	 * @return array
	 */
	public function asArray();
}