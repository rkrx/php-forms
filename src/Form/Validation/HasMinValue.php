<?php
namespace Forms\Form\Validation;

use Forms\Form\Common\RecursiveStructureAccessTrait;
use Forms\Form\Validation\Abstractions\Validator;
use Forms\Form\Validation\Result\ValidationResultMessage;

class HasMinValue implements Validator {
	use RecursiveStructureAccessTrait;

	private int $value;
	private string $message;

	/**
	 * @param float $value
	 * @param string $message
	 */
	public function __construct(int $value, string $message = 'The minimum value for this field {minValue} was not reached') {
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
		$data['attributes']['minValue'] = $data['attributes']['minValue'] ?? $this->value;
		return $data;
	}

	/**
	 * @param array $data
	 * @param string[] $path
	 * @return ValidationResultMessage[]
	 */
	public function __invoke(array $data, array $path): array {
		$value = self::getTrimmedString($data, $path);
		if($value !== '' && bccomp($this->value, $value, 8) === -1) {
			return [new ValidationResultMessage($this->message, ['minValue' => $this->value])];
		}
		return [];
	}
}
