<?php
namespace Forms\Form;

class Money extends DecimalNumber {
	/**
	 * @param array $data
	 * @param bool $validate
	 * @return array
	 */
	public function render(array $data, bool $validate = false): array {
		$fieldData = parent::render($data, $validate);
		$fieldData['type'] = 'money';
		return $fieldData;
	}
}
