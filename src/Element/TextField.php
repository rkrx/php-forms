<?php
namespace Kir\Forms\Element;

use Kir\Forms\AbstractNamedElement;
use Kir\Forms\Filtering\FilterAwareTrait;
use Kir\Forms\Validation\ValidatorAwareTrait;

class TextField extends AbstractNamedElement {
	use ValidatorAwareTrait;
	use FilterAwareTrait;

	/**
	 * @param string $fieldName
	 */
	public function __construct($fieldName) {
		parent::__construct('text', $fieldName);
	}

	/**
	 * @param array $data
	 * @return array
	 */
	public function convert(array $data) {
		$data = parent::convert($data);
		$filters = $this->getFilters();
		$fieldName = $this->getFieldName();
		$fieldValue = null;
		if(array_key_exists($fieldName, $data)) {
			$fieldValue = $data[$fieldName];
			foreach($filters as $filter) {
				$fieldValue = $filter->filter($fieldValue);
			}
		}
		$data[$fieldName] = $fieldValue;
		return $data;
	}
}