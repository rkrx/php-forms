<?php
namespace Forms\Form;

use Forms\Form\Abstractions\AbstractInput;
use Forms\Form\Common\JSON;
use Forms\Form\Common\RecursiveStructureAccessTrait;

/**
 * Other than normal HTML hidden fields, this hidden field should also be able to transfer data that is more than simple
 * strings. In HTML, the data is then represented as JSON values and thus often retains its original data type.
 *
 * You can still control the values that can be transferred with this field using validators and filters.
 */
class Hidden extends AbstractInput {
	use RecursiveStructureAccessTrait;

	public function convert(array $data): array {
		$json = self::getTrimmedString($data, $this->getFieldPath(), 'null');
		$value = JSON::parse($json);
		$data = self::set($data, $this->getFieldPath(), $value);
		return parent::convert($data);
	}

	/**
	 * @param array $data
	 * @param bool $validate
	 * @return array
	 */
	public function render(array $data, bool $validate = false): array {
		$fieldData = parent::render($data, $validate);
		$fieldData['type'] = 'hidden';
		return $fieldData;
	}
}
