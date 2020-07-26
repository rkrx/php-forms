<?php
namespace Forms\Form\Abstractions;

use ArrayIterator;
use Forms\Form\Validation\Result\ContainerValidationResult;
use IteratorAggregate;
use Traversable;

abstract class AbstractContainerElement implements FormElement, IteratorAggregate {
	/** @var FormElement[] */
	private array $elements;

	public function __construct(FormElement ...$elements) {
		$this->elements = $elements;
	}

	public function convert(array $data): array {
		foreach($this->elements as $element) {
			$data = $element->convert($data);
		}
		return $data;
	}

	/**
	 * @param array $data
	 * @return ContainerValidationResult
	 */
	public function validate(array $data): ContainerValidationResult {
		$validationResults = [];
		foreach($this->elements as $element) {
			$result = $element->validate($data);
			$validationResults[] = $result;
		}
		return new ContainerValidationResult(...$validationResults);
	}

	/**
	 * @param array $data
	 * @param bool $validate
	 * @return array
	 */
	public function render(array $data, bool $validate = false): array {
		$elements = [];
		foreach($this->elements as $element) {
			$elements[] = $element->render($data, $validate);
		}
		return [
			'type' => 'container',
			'elements' => $elements
		];
	}

	/**
	 * @return FormElement[]
	 */
	public function getElements(): array {
		return $this->elements;
	}

	/**
	 * @return Traversable|FormElement[]
	 */
	public function getIterator() {
		return new ArrayIterator($this->elements);
	}
}
