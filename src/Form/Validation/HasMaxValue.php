<?php
namespace Forms\Form\Validation;

use Forms\Form\Common\RecursiveStructureAccessTrait;
use Forms\Form\Validation\Abstractions\Validator;
use Forms\Form\Validation\Result\ValidationResultMessage;

class HasMaxValue implements Validator {
	use RecursiveStructureAccessTrait;

	private int $value;
	private string $message;

	/**
	 * @param float $value
	 * @param string $message
	 */
	public function __construct(float $value, string $message = 'The maximum value for this field {minValue} was not reached') {
		$this->value = $value;
		$this->message = $message;
	}

	/**
	 * Has the chance to add data to the render-data.
	 * For example: required => true
	 *
	 * @param array $data
	 * @return array
	 */
	public function render(array $data): array {
		$data['attributes']['maxValue'] = $data['attributes']['maxValue'] ?? $this->value;
		return $data;
	}

	/**
	 * @param array $data
	 * @param string[] $path
	 * @return ValidationResultMessage[]
	 */
	public function __invoke(array $data, array $path): array {
		$value = self::getString($data, $path);
		if(($value ?? '') !== '') {
			$actualLength = mb_strlen($value, 'UTF-8');
			if($actualLength < $this->value) {
				return [new ValidationResultMessage($this->message, ['maxValue' => $this->value])];
			}
		}
		return [];
	}
}
