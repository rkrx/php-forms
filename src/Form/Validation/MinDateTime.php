<?php
namespace Forms\Form\Validation;

use DateTime;
use Forms\Form\Common\RecursiveStructureAccessTrait;
use Forms\Form\Validation\Abstractions\Validator;
use Forms\Form\Validation\Result\ValidationResultMessage;

class MinDateTime implements Validator {
	use RecursiveStructureAccessTrait;

	private DateTime $date;
	private string $message;

	/**
	 * @param string|DateTime $date
	 * @param string $message
	 */
	public function __construct($date, string $message = 'The minimum date for this field {minValue} was not reached') {
		$this->date = is_string($date) ? date_create_immutable($date) : $date;
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
		$data['attributes']['minDateTime'] = $data['attributes']['minDateTime'] ?? $this->date;
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
			if($actualLength < $this->date) {
				return [new ValidationResultMessage($this->message, ['maxValue' => $this->date])];
			}
		}
		return [];
	}
}
