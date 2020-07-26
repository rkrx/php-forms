<?php
namespace Forms\Form;

use Forms\Form\Abstractions\AbstractInput;
use Forms\Form\Common\InvalidValue;
use Forms\Form\Common\RecursiveStructureAccessTrait;
use Forms\Form\Validation\Result\ElementValidationResult;
use Forms\Form\Validation\Result\ValidationResultMessage;

class Dropdown extends AbstractInput {
	use RecursiveStructureAccessTrait;

	protected array $options = [];
	protected ?string $defaultKey = null;

	/**
	 * @param string[] $fieldNamePath
	 * @param string $caption
	 * @param array $options
	 * @param array $attributes
	 */
	public function __construct(array $fieldNamePath, string $caption, array $options = [], array $attributes = []) {
		parent::__construct($fieldNamePath, $caption, $attributes);
		$this->addOptions($options);
	}

	/**
	 * @return array
	 */
	public function getOptions(): array {
		return $this->options;
	}

	/**
	 * @param string $key
	 * @param string $value
	 * @return $this
	 */
	public function addOption(string $key, string $value): self {
		$this->options[$key] = $value;
		return $this;
	}

	/**
	 * @param array $options
	 * @return $this
	 */
	public function addOptions(array $options): self {
		foreach($options as $key => $value) {
			$this->addOption($key, $value);
		}
		return $this;
	}

	/**
	 * @return string|null
	 */
	public function getDefaultKey(): ?string {
		return $this->defaultKey ?? (array_keys($this->options)[0] ?? $this->defaultKey);
	}

	/**
	 * @param string|null $defaultKey
	 * @return $this
	 */
	public function setDefaultKey(?string $defaultKey) {
		$this->defaultKey = $defaultKey;
		return $this;
	}

	/**
	 * @param array $data
	 * @return array
	 */
	public function convert(array $data): array {
		// is fieldname set in data array?
		if(!self::has($data, $this->getFieldPath())) {
			$data = self::set($data, $this->getFieldPath(), $this->defaultKey);
		} else {
			$options = $this->getOptions();
			$key = self::getString($data, $this->getFieldPath());

			if(array_key_exists($key, $options)) {
				$data = self::set($data, $this->getFieldPath(), $options[$key]);
			} else {
				$data = self::set($data, $this->getFieldPath(), new InvalidValue($key));
			}
		}

		return $data;
	}

	/**
	 * @param array $data
	 * @return ElementValidationResult
	 */
	public function validate(array $data): ElementValidationResult {
		$result = parent::validate($data);
		$value = self::get($data, $this->getFieldPath());
		if($value instanceof InvalidValue) {
			$message = new ValidationResultMessage($this->getAttribute('validation-messages')['Invalid selection'] ?? 'Invalid selection');
			$result = new ElementValidationResult($this, $message, ...$result->getMessages());
		} else {
			$value = self::getString($data, $this->getFieldPath());
			if(!array_key_exists($value, $this->options)) {
				$message = new ValidationResultMessage($this->getAttribute('validation-messages')['Invalid selection'] ?? 'Invalid selection');
				$result = new ElementValidationResult($this, $message, ...$result->getMessages());
			}
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
		$fieldValue = $fieldData['value'] ?? null;

		$fieldData['type'] = 'dropdown';
		$fieldData['options'] = $this->options;

		if($fieldValue !== null && array_key_exists($fieldValue, $this->options)) {
			$fieldData['value'] = $fieldValue;
		} elseif($this->defaultKey !== null && array_key_exists($this->defaultKey, $this->options)) {
			$fieldData['value'] = $this->defaultKey;
		} else {
			unset($fieldData['value']);
		}

		return $fieldData;
	}
}
