<?php
namespace Kir\Forms;

use Kir\Forms\Filtering\FilterAwareTrait;
use Kir\Forms\Misc\MetaData;
use Kir\Forms\Tools\RecursiveArrayAccess;
use Kir\Forms\Validation\ValidationResult;
use Kir\Forms\Validation\ValidatorAwareTrait;

abstract class AbstractTextField extends AbstractNamedElement {
	use ValidatorAwareTrait;
	use FilterAwareTrait;

	/** @var string */
	private $title = null;

	/**
	 * @param string $fieldPath
	 * @param string $title
	 */
	public function __construct($fieldPath, $title) {
		parent::__construct($fieldPath);
		$this->setTitle($title);
	}

	/**
	 * @return string
	 */
	public function getTitle() {
		return $this->title;
	}

	/**
	 * @param string $title
	 * @return $this
	 */
	public function setTitle($title) {
		$this->title = $title;
		return $this;
	}

	/**
	 * @param array $data
	 * @param MetaData $metaData
	 * @return array
	 */
	public function convert(array $data, MetaData $metaData = null) {
		$data = parent::convert($data, $metaData);
		$filters = $this->getFilters();
		$fieldPath = $this->getFieldPath();
		if($metaData !== null) {
			$parentDataPath = $metaData->getParentDataPath();
			$fieldPath = array_merge($parentDataPath, $fieldPath);
		}
		$fieldValue = null;
		if(RecursiveArrayAccess::has($data, $fieldPath)) {
			$fieldValue = RecursiveArrayAccess::getString($data, $fieldPath);
			foreach($filters as $filter) {
				$fieldValue = $filter->filter($fieldValue);
			}
		}
		$data = RecursiveArrayAccess::set($data, $fieldPath, $fieldValue);
		return $data;
	}

	/**
	 * @param array $data
	 * @param MetaData $metaData
	 * @return ValidationResult
	 */
	public function validate(array $data, MetaData $metaData = null) {
		$validationResult = parent::validate($data, $metaData);
		$validators = $this->getValidators();
		$fieldPath = $this->getFieldPath();
		if($metaData !== null) {
			$fieldPath = array_merge($metaData->getParentDataPath(), $fieldPath);
		}
		if(RecursiveArrayAccess::has($data, $fieldPath)) {
			$value = RecursiveArrayAccess::getString($data, $fieldPath);
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
	 * @param MetaData $metaData
	 * @return array
	 */
	public function render(array $data, $validate = false, MetaData $metaData = null) {
		$renderedData = parent::render($data, $validate, $metaData);
		$dataPath = $this->getFullDataPath($metaData);
		$renderedData['title'] = $this->title;
		$data = $this->filterData($data, $dataPath);
		if($validate) {
			$renderedData['messages'] = $this->validate($data, $metaData)->getErrorMessages();
		}
		$renderedData = $this->validateData($renderedData);
		$renderedData = $this->getEventHandler()->fireEvent('render', $renderedData);
		return $renderedData;
	}

	/**
	 * @param $renderedData
	 * @return mixed
	 */
	public function validateData($renderedData) {
		$renderedData['validation'] = [];
		foreach($this->getValidators() as $validator) {
			$validatorData = $validator->asArray();
			if(!array_key_exists($validatorData['type'], $renderedData['validation'])) {
				$renderedData['validation'][$validatorData['type']] = $validatorData;
			}
		}
		return $renderedData;
	}

	/**
	 * @param array $data
	 * @param $fieldPath
	 * @return array
	 */
	public function filterData(array $data, $fieldPath) {
		$filters = $this->getFilters();
		if(RecursiveArrayAccess::has($data, $fieldPath)) {
			$fieldValue = RecursiveArrayAccess::getString($data, $fieldPath);
			foreach($filters as $filter) {
				$fieldValue = $filter->filter($fieldValue);
			}
			$data = RecursiveArrayAccess::set($data, $fieldPath, $fieldValue);
			return $data;
		}
		return $data;
	}
}