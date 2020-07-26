<?php
namespace Forms\Form;

use DateTimeInterface;
use Forms\Form\Abstractions\AbstractInput;
use Forms\Form\Common\DateTimeUtils;
use Forms\Form\Common\InvalidValue;
use Forms\Form\Common\RecursiveStructureAccessTrait;
use Forms\Form\Validation\Result\ElementValidationResult;
use Forms\Form\Validation\Result\ValidationResultMessage;

class DatePicker extends AbstractInput {
	use RecursiveStructureAccessTrait;

	public function convert(array $data): array {
		$path = $this->getFieldPath();
		$value = self::getTrimmedString($data, $path, null);
		$dt = DateTimeUtils::getDateTimeImmutable($value);
		if($dt === null || $dt instanceof InvalidValue) {
			return self::set($data, $path, $dt);
		}
		return self::set($data, $path, $dt->format('Y-m-d'));
	}

	public function validate(array $data): ElementValidationResult {
		$result = parent::validate($data);
		$value = self::get($data, $this->getFieldPath());
		$dt = DateTimeUtils::getDateTimeImmutable($value);
		if($dt instanceof InvalidValue) {
			return new ElementValidationResult($this, new ValidationResultMessage('Invalid date'), ...$result->getMessages());
		}
		return $result;
	}

	public function render(array $data, bool $validate = false): array {
		$value = self::getTrimmedString($data, $this->getFieldPath(), '');
		$dt = DateTimeUtils::getDateTimeImmutable($value);
		if($dt instanceof DateTimeInterface) {
			$data = self::set($data, $this->getFieldPath(), $dt->format('Y-m-d'));
		}
		$fieldData = parent::render($data, $validate);
		$fieldData['type'] = 'datepicker';
		return $fieldData;
	}
}
