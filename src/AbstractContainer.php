<?php
namespace Kir\Forms;

use Kir\Forms\Validation\ValidationResult;

abstract class AbstractContainer implements Container {
	/** @var Element[] */
	private $elements = [];

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
	 * @return ValidationResult
	 */
	public function validate(array $data) {
		foreach($this->elements as $element) {
			$data = $element->validate($data);
		}
		return $data;
	}

	/**
	 * @param array $data
	 * @param bool $validate
	 * @return array
	 */
	public function render(array $data, $validate = false) {
		$renderedData = [
			'children' => [],
			'validationMessages' => [],
			'valid' => false
		];
		foreach($this->elements as $element) {
			$renderedData['children'][] = $element->render($data, $validate);
			if($validate) {
				$validationResult = $element->validate($data);
				$renderedData['valid'] = $renderedData['valid'] && $validationResult->hasErrorMessages();
			}
		}
		return $renderedData;
	}
}