<?php
namespace Forms\Form\Validation;

use Forms\Form\Common\RecursiveStructureAccess as Arr;
use Forms\Form\Validation\Abstractions\Validator;
use Forms\Form\Validation\Result\ValidationResultMessage;

class IsRequired implements Validator {
	private string $message;

	public function __construct(string $message = 'Input required') {
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
		$data['attributes']['required'] = $data['attributes']['required'] ?? true;
		return $data;
	}

	/**
	 * @param array $data
	 * @param string[] $path
	 * @return ValidationResultMessage[]
	 */
	public function __invoke(array $data, array $path): array {
		if(!Arr::has($data, $path)) {
			return [new ValidationResultMessage($this->message)];
		}
		$value = Arr::get($data, $path);
		if(!is_scalar($value) || trim($value) === '') {
			return [new ValidationResultMessage($this->message)];
		}
		return [];
	}
}
