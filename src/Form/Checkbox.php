<?php
namespace Forms\Form;

use Forms\Form\Abstractions\AbstractInput;
use Forms\Form\Common\RecursiveStructureAccess;

class Checkbox extends AbstractInput {
	/** @var callable|null */
	private $translateInput;

	public function __construct(array $fieldNamePath, string $caption, array $attributes = [], $translateInput = null) {
		parent::__construct($fieldNamePath, $caption, $attributes);
		$this->translateInput = $translateInput;
	}

	/**
	 * @param array $data
	 * @return array
	 */
	public function convert(array $data): array {
		$data = parent::convert($data);
		$value = (bool) RecursiveStructureAccess::get($data, $this->getFieldPath(), false);
		$data = RecursiveStructureAccess::set($data, $this->getFieldPath(), $value);
		return $data;
	}

	/**
	 * @param array $data
	 * @param bool $validate
	 * @return array
	 */
	public function render(array $data, bool $validate = false): array {
		$fieldData = parent::render($data, $validate);
		$fieldData['type'] = 'checkbox';
		if($this->translateInput) {
			$fieldData['value'] = (bool) call_user_func($this->translateInput, $fieldData['value']);
		}
		return $fieldData;
	}
}
