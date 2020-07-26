<?php
namespace Forms\Form\Validation;

use Forms\Form\Common\Params;
use Forms\Form\Validation\Abstractions\Validator;
use Forms\Form\Validation\Result\ValidationResultMessage;

class BooleanCallbackValidator implements Validator {
	/** @var callable */
	private $fn;
	/** @var callable */
	private $argsFn;
	/** @var string */
	private string $message;

	/**
	 * @param callable $fn
	 * @param callable $argsFn
	 * @param string $message
	 */
	public function __construct($fn, string $message, $argsFn) {
		$this->fn = $fn;
		$this->argsFn = $argsFn;
		$this->message = $message;
	}

	/**
	 * @inheritDoc
	 */
	public function render(array $data): array {
		return $data;
	}

	/**
	 * @param array $data
	 * @param string[] $path
	 * @return array
	 */
	public function __invoke(array $data, array $path): array {
		$params = new Params($data, $path);
		if(!call_user_func($this->fn, $params)) {
			return [new ValidationResultMessage($this->message)];
		}
		return [];
	}
}
