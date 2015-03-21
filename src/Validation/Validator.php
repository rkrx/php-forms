<?php
namespace Kir\Forms\Validation;

use Exception;
use Kir\Forms\Nodes\Node;

interface Validator {
	/**
	 * @param int|float|string|array $value
	 * @param Node $node
	 * @return string[]
	 * @throws Exception
	 */
	public function validate($value, Node $node);

	/**
	 * @return array
	 */
	public function asArray();
}