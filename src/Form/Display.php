<?php
namespace Forms\Form;

use Forms\Form\Abstractions\AbstractInput;

class Display extends AbstractInput {
	/**
	 * @param array $data
	 * @param bool $validate
	 * @return array
	 */
	public function render(array $data, bool $validate = false): array {
		$fieldData = parent::render($data, $validate);
		$fieldData['type'] = 'display';
		return $fieldData;
	}
}
