<?php
namespace Kir\Forms;

use Kir\Forms\Misc\MetaData;
use Kir\Forms\Validation\ValidationResult;

abstract class AbstractContainer implements Container {
	/** @var Element[] */
	private $elements = [];
	/** @var string */
	private $type = 'unknown';

	/**
	 */
	public function __construct() {
	}

	/**
	 * @return string
	 */
	public function getType() {
		return $this->type;
	}

	/**
	 * @param string $type
	 * @return $this
	 */
	public function setType($type) {
		$this->type = $type;
		return $this;
	}

	/**
	 * @param Element $element
	 * @return $this
	 */
	public function add(Element $element) {
		$this->elements[] = $element;
		return $this;
	}

	/**
	 * @return Element[]
	 */
	protected function getChildren() {
		return $this->elements;
	}

	/**
	 * @param array $data
	 * @return array
	 */
	public function convert(array $data) {
		foreach($this->elements as $element) {
			$data = $element->convert($data);
		}
		return $data;
	}

	/**
	 * @param array $data
	 * @param MetaData $metaData
	 * @return ValidationResult
	 */
	public function validate(array $data, MetaData $metaData = null) {
		$result = new ValidationResult();
		foreach($this->elements as $element) {
			$elementResult = $element->validate($data, $metaData);
			if($elementResult->hasErrorMessages()) {
				$result->setHasInnerErrors(true);
			}
		}
		return $result;
	}

	/**
	 * @param array $data
	 * @param bool $validate
	 * @param MetaData $metaData
	 * @return array
	 */
	public function render(array $data, $validate = false, MetaData $metaData = null) {
		$renderedData = [
			'type' => $this->type,
			'validationMessages' => [],
			'valid' => true,
			'children' => [],
		];
		foreach($this->elements as $element) {
			$renderedData['children'][] = $element->render($data, $validate, $metaData);
			if($validate) {
				$validationResult = $element->validate($renderedData);
				$hasErrorMessages = $validationResult->hasErrorMessages();
				$hasInnerErrors = $validationResult->hasInnerErrors();
				$renderedData['valid'] = $renderedData['valid'] && (!$hasErrorMessages && $hasInnerErrors);
			}
		}
		return $renderedData;
	}
}