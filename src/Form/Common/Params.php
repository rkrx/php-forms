<?php
namespace Forms\Form\Common;

class Params {
	private array $data;
	private array $keyPath;

	/**
	 * @param array $data
	 * @param array $keyPath
	 */
	public function __construct(array $data, array $keyPath) {
		$this->data = $data;
		$this->keyPath = $keyPath;
	}

	/**
	 * @return array
	 */
	public function getData(): array {
		return $this->data;
	}

	/**
	 * @return array
	 */
	public function getKeyPath(): array {
		return $this->keyPath;
	}

	/**
	 * @return mixed
	 */
	public function getValue() {
		return RecursiveStructureAccess::get($this->data, $this->keyPath);
	}

	/**
	 * @param null $default
	 * @return bool|int|float|string|null
	 */
	public function getString($default = null) {
		$value = $this->getValue();
		if(is_scalar($value) || $value === null) {
			return (string) $value;
		}
		return $default;
	}

	/**
	 * @param null $default
	 * @return bool|int|float|string|null
	 */
	public function getScalarValue($default = null) {
		$value = $this->getValue();
		if(is_scalar($value) || $value === null) {
			return $value;
		}
		return $default;
	}

	/**
	 * @return bool
	 */
	public function isNull(): bool {
		return $this->getValue() === null;
	}

	/**
	 * @return bool
	 */
	public function isScalar(): bool {
		return is_scalar($this->getValue());
	}

	/**
	 * @return bool
	 */
	public function isArray(): bool {
		return is_array($this->getValue());
	}

	/**
	 * @return bool
	 */
	public function isObject(): bool {
		return is_object($this->getValue());
	}
}
