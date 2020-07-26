<?php
namespace Forms\Form;

use Forms\Form\Abstractions\AbstractInput;
use Forms\Form\Common\RecursiveStructureAccessTrait;

class Password extends AbstractInput {
	use RecursiveStructureAccessTrait;

	public function convert(array $data): array {
		$data = parent::convert($data);
		$path = $this->getFieldPath();
		$value = self::getTrimmedString($data, $path);
		return self::set($data, $path, $value);
	}

	/**
	 * @param array $data
	 * @param bool $validate
	 * @return array
	 */
	public function render(array $data, bool $validate = false): array {
		$fieldData = parent::render($data, $validate);
		$fieldData['type'] = 'password';
		return $fieldData;
	}
}
