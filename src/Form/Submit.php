<?php
namespace Forms\Form;

use Forms\Form\Abstractions\AbstractInput;

class Submit extends AbstractInput {
	/** @var mixed|null */
	private $value;

	/**
	 * @param string[] $path
	 * @param string $fieldLabel
	 * @param mixed|null $value
	 * @param array $attributes
	 */
	public function __construct(array $path, string $fieldLabel, $value = null, array $attributes = []) {
		parent::__construct($path, $fieldLabel, $attributes);
		$this->value = $value;
	}

	/**
	 * @param array $data
	 * @param bool $validate
	 * @return array
	 */
	public function render(array $data, bool $validate = false): array {
		$fieldData = parent::render($data, $validate);
		$fieldData['type'] = 'submit';
		$fieldData['value'] = $this->value;
		return $fieldData;
	}
}
