<?php
namespace Forms\Form;

class Radio extends Dropdown {
	/**
	 * @param array $data
	 * @param bool $validate
	 * @return array
	 */
	public function render(array $data, bool $validate = false): array {
		$fieldData = parent::render($data, $validate);
		$fieldData['type'] = 'radio';
		return $fieldData;
	}
}
