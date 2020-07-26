<?php
namespace Forms\Form;

use Forms\Form\Abstractions\AbstractInput;
use Forms\Form\Common\RecursiveStructureAccess as RSA;

class Input extends AbstractInput {
	/**
	 * Ensure the component's path-value is a string or null
	 *
	 * @param array $data
	 * @return array
	 */
	public function convert($data): array {
		$data = parent::convert($data);
		$value = RSA::get($data, $this->getFieldPath(), null);
		if(!is_scalar($value)) {
			$data = RSA::set($data, $this->getFieldPath(), null);
		}
		return $data;
	}

	/**
	 * @param array $data
	 * @param bool $validate
	 * @return array
	 */
	public function render(array $data, bool $validate = false): array {
		$fieldData = parent::render($data, $validate);
		$fieldData['type'] = 'input';
		return $fieldData;
	}
}
