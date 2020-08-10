<?php
namespace Forms\Form\Validation;

use Forms\Form\Common\RecursiveStructureAccessTrait;
use Forms\Form\Validation\Abstractions\Validator;
use Forms\Form\Validation\Result\ValidationResultMessage;

class MinLength implements Validator {
	use RecursiveStructureAccessTrait;

	private int $length;
	private string $message;

	/**
	 * @param int $length
	 * @param string $message
	 */
	public function __construct(int $length, string $message = 'Minimum length of {length} missed by {missedBy} characters') {
		$this->length = $length;
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
		$data['attributes']['minLength'] = $data['attributes']['minLength'] ?? $this->length;
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
			if($actualLength < $this->length) {
				return [new ValidationResultMessage($this->message, ['length' => $this->length, 'actualLength' => $actualLength, 'missedBy' => $this->length - $actualLength])];
			}
		}
		return [];
	}
}
