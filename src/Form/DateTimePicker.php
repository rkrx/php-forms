<?php
namespace Forms\Form;

use DateTimeInterface;
use Forms\Form\Abstractions\AbstractInput;
use Forms\Form\Common\DateTimeUtils;
use Forms\Form\Common\InvalidValue;
use Forms\Form\Common\RecursiveStructureAccessTrait;
use Forms\Form\Validation\Result\ElementValidationResult;
use Forms\Form\Validation\Result\ValidationResultMessage;

class DateTimePicker extends AbstractInput {
	use RecursiveStructureAccessTrait;

	/** @var callable|null */
	private $dateParser;

	public function __construct(array $fieldNamePath, string $caption, array $attributes = [], $dateParser = null) {
		parent::__construct($fieldNamePath, $caption, $attributes);
		$this->dateParser = $dateParser;
	}

	/**
	 * @param array $data
	 * @return array
	 */
	public function convert(array $data): array {
		$data = parent::convert($data);
		$path = $this->getFieldPath();
		$dateTime = self::getTrimmedString($data, $path);
		$dt = DateTimeUtils::getDateTimeImmutable($dateTime);
		if($dt === null || $dt instanceof InvalidValue) {
			return self::set($data, $path, $dt);
		}
		return self::set($data, $path, $dt->format('c'));
	}

	/**
	 * @param array $data
	 * @return ElementValidationResult
	 */
	public function validate(array $data): ElementValidationResult {
		$result = parent::validate($data);
		if(self::isInvalidValue($data, $this->getFieldPath()) || date_create_immutable(self::getString($data, $this->getFieldPath())) === false) {
			$result = new ElementValidationResult($this, new ValidationResultMessage('Invalid date time'), ...$result->getMessages());
		}
		return $result;
	}

	/**
	 * @param array $data
	 * @param bool $validate
	 * @return array
	 */
	public function render(array $data, bool $validate = false): array {
		$value = self::getTrimmedString($data, $this->getFieldPath(), '');
		$dt = DateTimeUtils::getDateTimeImmutable($value);
		if($dt instanceof DateTimeInterface) {
			$data = self::set($data, $this->getFieldPath(), $dt->format('c'));
		}
		$fieldData = parent::render($data, $validate);
		$fieldData['type'] = 'datetime-picker';
		return $fieldData;
	}
}
