<?php
namespace Forms\Form\Validation;

use Forms\Form\Common\RecursiveStructureAccessTrait;
use Forms\Form\Validation\Abstractions\Validator;
use Forms\Form\Validation\Result\ValidationResultMessage;

class IsValidEmail implements Validator {
	use RecursiveStructureAccessTrait;

	private string $message;

	/**
	 * @param string $message
	 */
	public function __construct(string $message = 'Invalid email address pattern') {
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
		return $data;
	}

	/**
	 * @param array $data
	 * @param string[] $path
	 * @return ValidationResultMessage[]
	 */
	public function __invoke(array $data, array $path): array {
		if(self::has($data, $path)) {
			$value = self::get($data, $path);
			if(!is_string($value) || filter_var($value, FILTER_VALIDATE_EMAIL) === false) {
				return [new ValidationResultMessage($this->message)];
			}
		}
		return [];
	}
}
