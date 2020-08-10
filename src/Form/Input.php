<?php
namespace Forms\Form;

use Forms\Form\Abstractions\AbstractInput;
use Forms\Form\Common\Builder;
use Forms\Form\Common\RecursiveStructureAccess as RSA;
use Forms\Form\Validation\MaxLength;
use Forms\Form\Validation\MinLength;

class Input extends AbstractInput {
	public function __construct(array $fieldNamePath, string $caption, array $attributes = []) {
		parent::__construct($fieldNamePath, $caption, $attributes);
		Builder::attrs($attributes, [
			'minlength', fn (bool $len) => $this->addValidator(new MinLength($len)),
			'maxlength', fn (bool $len) => $this->addValidator(new MaxLength($len))
		]);
	}

	/**
	 * Ensure the component's path-value is a string or null
	 *
	 * @param array $data
	 * @return array
	 */
	public function convert(array $data): array {
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
