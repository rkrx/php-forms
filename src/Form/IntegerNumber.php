<?php
namespace Forms\Form;

use Forms\Form\Abstractions\AbstractInput;
use Forms\Form\Common\InvalidValue;
use Forms\Form\Common\RecursiveStructureAccessTrait;
use Forms\Form\Validation\Result\ElementValidationResult;
use Forms\Form\Validation\Result\ValidationResultMessage;

class IntegerNumber extends AbstractInput {
	use RecursiveStructureAccessTrait;

	public function convert(array $data): array {
		$data = parent::convert($data);
		$value = self::getTrimmedString($data, $this->getFieldPath(), null);
		if($value === '' ||$value === null) {
			$value = 0;
		} elseif(!self::isValid($value)) {
			$value = new InvalidValue($value);
		}
		return self::set($data, $this->getFieldPath(), $value);
	}

	public function validate(array $data): ElementValidationResult {
		$result = parent::validate($data);
		$value = self::get($data, $this->getFieldPath(), null);
		if($value instanceof InvalidValue) {
			$result = new ElementValidationResult($this, new ValidationResultMessage('Invalid value'), ...$result->getMessages());
		} elseif(!self::isValid($value)) {
			$result = new ElementValidationResult($this, new ValidationResultMessage('Invalid value'), ...$result->getMessages());
		}
		return $result;
	}

	/**
	 * @param array $data
	 * @param bool $validate
	 * @return array
	 */
	public function render(array $data, bool $validate = false): array {
		$fieldData = parent::render($data, $validate);
		$fieldData['type'] = 'integer-number';
		return $fieldData;
	}

	private static function isValid($input) {
		if(!is_scalar($input)) {
			return false;
		}
		if(preg_match('/^[+-]?(?:[1-9]\\d*|0)$/', $input)) {
			return true;
		}
		return false;
	}
}
