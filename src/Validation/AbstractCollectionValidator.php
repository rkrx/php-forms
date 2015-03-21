<?php
namespace Kir\Forms\Validation;

use Exception;
use Kir\Forms\Nodes\Node;

abstract class AbstractCollectionValidator implements CollectionValidator {
	/**
	 */
	public function __construct() {
	}

	/**
	 * @param int|float|string|array $data
	 * @param Node $node
	 * @return string[]
	 * @throws Exception
	 */
	public function validate($data, Node $node) {
		if(!is_array($data)) {
			throw new Exception("Requires data to be an array");
		}
		return [];
	}

	/**
	 * @return array
	 */
	public function asArray() {
		return [];
	}
}