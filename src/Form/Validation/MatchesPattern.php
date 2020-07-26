<?php
namespace Forms\Form\Validation;

use Forms\Form\Common\RecursiveStructureAccessTrait;
use Forms\Form\Validation\Abstractions\Validator;
use Forms\Form\Validation\Result\ValidationResultMessage;

class MatchesPattern implements Validator {
	use RecursiveStructureAccessTrait;

	private string $pattern;
	private ?string $message;

	/**
	 * @param string $pattern
	 * @param null|string $message
	 */
	public function __construct(string $pattern, ?string $message = 'Input does not match required pattern') {
		$this->pattern = $pattern;
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
		/*
		 * Only works, if no modifiers applied.
		 * So something like `/\d+/` works, while `/\d+/iu` does not.
		 * Caution: The HTML5-Regular-Expression implementation could differ from the one in PHP
		 */
		if(preg_match('/^(.)(.*)\\1$/', $this->pattern, $matches)) {
			$pattern = $matches[2];
			$data['attributes'] = $data['attributes'] ?? [];
			$data['attributes']['pattern'] = $pattern;
		}
		return $data;
	}

	/**
	 * @param array $data
	 * @param string[] $path
	 * @return ValidationResultMessage[]
	 */
	public function __invoke(array $data, array $path): array {
		$value = self::getString($data, $path);
		if(self::has($data, $path) && $value) {
			if(!preg_match($this->pattern, $value)) {
				return [new ValidationResultMessage($this->message, ['pattern' => $this->pattern])];
			}
		}
		return [];
	}
}
