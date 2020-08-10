<?php
namespace Forms\Form\Validation;

use DateTime;
use DateTimeImmutable;
use DateTimeInterface;
use Forms\Form\Common\DateTime\DateTimeTrait;
use Forms\Form\Common\DateTime\InvalidDateTimeException;
use Forms\Form\Common\RecursiveStructureAccessTrait;
use Forms\Form\Validation\Abstractions\Validator;
use Forms\Form\Validation\Result\ValidationResultMessage;

class MaxDateTime implements Validator {
	use RecursiveStructureAccessTrait;
	use DateTimeTrait;

	private DateTimeImmutable $date;
	private string $message;

	/**
	 * @param string|DateTimeInterface $date
	 * @param string $message
	 */
	public function __construct($date, string $message = 'The maximum date for this field {maxDateTime} was exceeded') {
		$this->date = $this->asDateTime($date);
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
		$data['attributes']['maxDateTime'] = $data['attributes']['maxDateTime'] ?? $this->date->format('Y-m-d H:i');
		return $data;
	}

	/**
	 * @param array $data
	 * @param string[] $path
	 * @return ValidationResultMessage[]
	 */
	public function __invoke(array $data, array $path): array {
		$value = self::getString($data, $path);
		try {
			if($this->asDateTime($value) > $this->date) {
				return [new ValidationResultMessage($this->message, ['maxDateTime' => $this->date->format('Y-m-d H:i')])];
			}
		} catch (InvalidDateTimeException $e) {
			return [new ValidationResultMessage($e->getMessage())];
		}
		return [];
	}
}
