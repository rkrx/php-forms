<?php
namespace Forms\Form\Abstractions;

use Forms\Form\Common\RecursiveStructureAccess;
use Forms\Form\Filtering\Abstractions\Filter;
use Forms\Form\Validation\Abstractions\Validator;
use Forms\Form\Validation\Result\ElementValidationResult;

abstract class AbstractInput implements FormElement {
	/** @var Validator[][] */
	private static array $staticValidators = [];
	/** @var Filter[][] */
	private static array $staticFilters = [];
	/** @var array */
	private array $attributes;

	/**
	 * @param Validator ...$validators
	 */
	public static function addClassValidator(Validator ...$validators): void {
		foreach($validators as $validator) {
			self::$staticValidators[static::class] = self::$staticValidators[static::class] ?? [];
			self::$staticValidators[static::class][] = $validator;
		}
	}

	/**
	 * @param Filter ...$filters
	 */
	public static function addClassFilter(Filter...$filters): void {
		foreach($filters as $filter) {
			self::$staticFilters[static::class] = self::$staticFilters[static::class] ?? [];
			self::$staticFilters[static::class][] = $filter;
		}
	}

	/** @var string[] */
	private array $fieldNamePath;
	/** @var string */
	private string $caption;
	/** @var Validator[] */
	private array $validators = [];
	/** @var Filter[] */
	private array $filters = [];

	/**
	 * @param array $fieldNamePath
	 * @param string $caption
	 * @param array $attributes
	 */
	public function __construct(array $fieldNamePath, string $caption, array $attributes = []) {
		$this->fieldNamePath = $fieldNamePath;
		$this->caption = $caption;
		$this->attributes = $attributes;
	}

	/**
	 * @return array
	 */
	public function getFieldPath(): array {
		return $this->fieldNamePath;
	}

	/**
	 * @return string
	 */
	public function getCaption(): string {
		return $this->caption;
	}

	/**
	 * @param string $key
	 * @return bool
	 */
	public function hasAttribute(string $key): bool {
		return array_key_exists($key, $this->attributes);
	}

	/**
	 * @param string $key
	 * @param mixed|null $default
	 * @return mixed
	 */
	public function getAttribute(string $key, $default = null) {
		if($this->hasAttribute($key)) {
			return $this->attributes[$key];
		}
		return $default;
	}

	/**
	 * @param string $key
	 * @param mixed $value
	 * @return $this
	 */
	public function setAttribute(string $key, $value): self {
		$this->attributes[$key] = $value;
		return $this;
	}

	/**
	 * @param Filter ...$filters
	 * @return $this
	 */
	public function addFilter(Filter ...$filters) {
		foreach($filters as $filter) {
			$this->filters[] = $filter;
		}
		return $this;
	}

	/**
	 * @param Validator ...$validators
	 * @return $this
	 */
	public function addValidator(Validator ...$validators): self {
		foreach($validators as $validator) {
			$this->validators[] = $validator;
		}
		return $this;
	}

	/**
	 * @param array $data
	 * @return array
	 */
	public function convert(array $data): array {
		foreach(self::$staticFilters[static::class] ?? [] as $filter) {
			$data = $filter($data, $this->fieldNamePath);
		}
		foreach($this->filters as $filter) {
			$data = $filter($data, $this->fieldNamePath);
		}
		return $data;
	}

	/**
	 * @param array $data
	 * @return ElementValidationResult
	 */
	public function validate(array $data): ElementValidationResult {
		$messages = [];
		foreach(self::$staticValidators[static::class] ?? [] as $validator) {
			foreach($validator($data, $this->fieldNamePath) as $validationResultMessage) {
				$messages[] = $validationResultMessage;
			}
		}
		foreach($this->validators as $validator) {
			foreach($validator($data, $this->fieldNamePath) as $validationResultMessage) {
				$messages[] = $validationResultMessage;
			}
		}
		return new ElementValidationResult($this, ...$messages);
	}

	/**
	 * @param array $data
	 * @param bool $validate
	 * @return array
	 */
	public function render(array $data, bool $validate = false): array {
		$messages = [];
		$isValid = null;

		if($validate) {
			$validationResult = $this->validate($data);
			$isValid = $validationResult->isValid();
			foreach($validationResult->getMessages() as $message) {
				$messages[] = $message;
			}
		}

		$fieldData = [
			'name' => $this->fieldNamePath,
			'title' => $this->caption,
			'value' => RecursiveStructureAccess::get($data, $this->fieldNamePath),
			'messages' => $messages,
			'attributes' => $this->attributes
		];

		if($isValid !== null) {
			$fieldData['valid'] = $isValid;
		}

		foreach($this->validators as $validator) {
			$fieldData = $validator->render($fieldData);
		}

		return $fieldData;
	}
}
