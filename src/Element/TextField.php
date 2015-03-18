<?php
namespace Kir\Forms\Element;

use Kir\Forms\AbstractNamedElement;
use Kir\Forms\Filtering\FilterAwareTrait;
use Kir\Forms\Validation\ValidationResult;
use Kir\Forms\Validation\ValidatorAwareTrait;

class TextField extends AbstractNamedElement {
	use ValidatorAwareTrait;
	use FilterAwareTrait;

	/** @var string */
	private $title;

	/**
	 * @param string $fieldName
	 * @param string $title
	 */
	public function __construct($fieldName, $title) {
		parent::__construct('text', $fieldName);
		$this->title = $title;
	}

	/**
	 * @param array $data
	 * @return array
	 */
	public function convert(array $data) {
		$data = parent::convert($data);
		$filters = $this->getFilters();
		$fieldName = $this->getFieldName();
		$fieldValue = null;
		if(array_key_exists($fieldName, $data)) {
			$fieldValue = $data[$fieldName];
			foreach($filters as $filter) {
				$fieldValue = $filter->filter($fieldValue);
			}
		}
		$data[$fieldName] = $fieldValue;
		return $data;
	}

	/**
	 * @param array $data
	 * @return ValidationResult
	 */
	public function validate(array $data) {
		$validationResult = parent::validate($data);
		$validators = $this->getValidators();
		$fieldName = $this->getFieldName();
		if(array_key_exists($fieldName, $data) && is_scalar($data[$fieldName])) {
			$value = $data[$fieldName];
			foreach($validators as $validator) {
				$messages = $validator->validate($value);
				foreach($messages as $message) {
					$validationResult->addErrorMessage($message);
				}
			}
		}
		return $validationResult;
	}

	/**
	 * @param array $data
	 * @param bool $validate
	 * @return array
	 */
	public function render(array $data, $validate = false) {
		$renderedData = parent::render($data, $validate);
		$renderedData['title'] = $this->title;
		$renderedData['value'] = '';
		$fieldName = $this->getFieldName();
		if(array_key_exists($fieldName, $data) && is_scalar($data[$fieldName])) {
			$value = $data[$fieldName];
			$renderedData['value'] = $value;
		}
		if($validate) {
			$renderedData['messages'] = $this->validate($data)->getErrorMessages();
		}
		return $renderedData;
	}
}