<?php
namespace Kir\Forms;

use Kir\Forms\Validation\ValidationResult;

abstract class AbstractElement implements Element {
	/** @var string */
	private $type;

	/**
	 * @param string $type
	 */
	public function __construct($type) {
		$this->type = $type;
	}

	/**
	 * @param array $data
	 * @return array
	 */
	public function convert(array $data) {
		return $data;
	}

	/**
	 * @param array $data
	 * @return ValidationResult
	 */
	public function validate(array $data) {
		return new ValidationResult();
	}

	/**
	 * @param array $data
	 * @param bool $validate
	 * @return array
	 */
	public function render(array $data, $validate = false) {
		$renderedData = [];
		$renderedData['type'] = $this->type;
		return $renderedData;
	}
}