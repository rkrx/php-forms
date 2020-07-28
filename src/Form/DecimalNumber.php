<?php
namespace Forms\Form;

use Forms\Form\Abstractions\AbstractInput;
use Forms\Form\Common\InvalidValue;
use Forms\Form\Common\RecursiveStructureAccessTrait;
use Forms\Form\Validation\Result\ElementValidationResult;
use Forms\Form\Validation\Result\ValidationResultMessage;

class DecimalNumber extends AbstractInput {
	use RecursiveStructureAccessTrait;

	private ?int $decimalPrecision;
	private string $decimalSeparator;

	/**
	 * @param array $fieldNamePath
	 * @param string $caption
	 * @param string $decimalSeparator
	 * @param int|null $decimalPrecision
	 * @param array $attributes
	 */
	public function __construct(array $fieldNamePath, string $caption, string $decimalSeparator = '.', int $decimalPrecision = null, array $attributes = []) {
		parent::__construct($fieldNamePath, $caption, $attributes);
		$this->decimalSeparator = $decimalSeparator;
		$this->decimalPrecision = $decimalPrecision;
	}

	public function convert(array $data): array {
		$data = parent::convert($data);
		$value = self::getTrimmedString($data, $this->getFieldPath());
		if((is_string($value) && trim($value) === '') || $value === null) {
			$value = '0.0';
		}
		if($this->decimalSeparator !== '.') {
			$value = strtr($value, [$this->decimalSeparator => '.']);
		}
		if(!is_numeric($value)) {
			return self::set($data, $this->getFieldPath(), new InvalidValue($value));
		}
		if($this->decimalPrecision !== null) {
			$value = number_format((float) $value, $this->decimalPrecision, '.', '');
		} elseif(is_numeric($value) && bccomp($value, 0, 8) === 0) {
			$value = '0.0';
		}
		return self::set($data, $this->getFieldPath(), $value);
	}

	public function validate(array $data): ElementValidationResult {
		$result = parent::validate($data);
		$value = self::getTrimmedString($data, $this->getFieldPath());
		if(!is_numeric($value)) {
			$result = new ElementValidationResult($this, new ValidationResultMessage('Invalid number'), ...$result->getMessages());
		}
		return $result;
	}

	public function render(array $data, bool $validate = false): array {
		$value = self::getTrimmedString($data, $this->getFieldPath(), null) ?: '';
		$convertedValue = $value;
		if($this->decimalPrecision) {
			$convertedValue = number_format((float) $value, $this->decimalPrecision, $this->decimalSeparator, '');
		}
		$data = self::set($data, $this->getFieldPath(), $value);
		$fieldData = parent::render($data, $validate);
		$fieldData['type'] = 'decimal-number';
		$fieldData['converted-value'] = $convertedValue;
		return $fieldData;
	}
}
