<?php
namespace Forms\Form;

use Forms\Form\Common\RecursiveStructureAccessTrait;
use Forms\Form\Validation\IsValidEmail;

class Email extends Input {
	use RecursiveStructureAccessTrait;

	/**
	 * @param array $fieldNamePath
	 * @param string $caption
	 * @param array $attributes
	 */
	public function __construct(array $fieldNamePath, string $caption, array $attributes = []) {
		parent::__construct($fieldNamePath, $caption, $attributes);
		$this->addValidator(new IsValidEmail);
	}

	/**
	 * @param array $data
	 * @return array
	 */
	public function convert($data): array {
		$data = parent::convert($data);
		$path = $this->getFieldPath();
		$value = self::getTrimmedString($data, $path, null);
		return self::set($data, $path, $value);
	}

	/**
	 * @param array $data
	 * @param bool $validate
	 * @return array
	 */
	public function render(array $data, bool $validate = false): array {
		$fieldData = parent::render($data, $validate);
		$fieldData['type'] = 'email';
		return $fieldData;
	}
}
