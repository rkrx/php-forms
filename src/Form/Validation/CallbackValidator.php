<?php
namespace Forms\Form\Validation;

use Forms\Form\Common\Params;
use Forms\Form\Validation\Abstractions\Validator;
use Forms\Form\Validation\Result\ValidationResultMessage;

class CallbackValidator implements Validator {
	/** @var callable */
	private $callback;

	/**
	 * @param callable $callback
	 */
	public function __construct(callable $callback) {
		$this->callback = $callback;
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
		$messages = call_user_func($this->callback, new Params($data, $path));
		if($messages === null) {
			$messages = [];
		} elseif(is_string($messages) || $messages instanceof ValidationResultMessage) {
			$messages = [$messages];
		}
		$result = [];
		foreach($messages as $message) {
			if($message instanceof ValidationResultMessage) {
				$result[] = $message;
			} elseif(is_string($message)) {
				$result[] = new ValidationResultMessage($message);
			}
		}
		return $result;
	}
}
