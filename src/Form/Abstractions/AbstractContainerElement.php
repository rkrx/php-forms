<?php
namespace Forms\Form\Abstractions;

use ArrayIterator;
use Forms\Form\Validation\Result\ContainerValidationResult;
use IteratorAggregate;
use Traversable;

abstract class AbstractContainerElement implements FormElement, IteratorAggregate {
	/** @var FormElement[] */
	private array $elements;

	/**
	 * @param FormElement ...$elements
	 */
	public function __construct(FormElement ...$elements) {
		$this->elements = $elements;
	}

	/**
	 * @param array $data
	 * @return array
	 */
	public function convert(array $data): array {
		return array_reduce($this->elements, fn ($d, FormElement $element) => $element->convert($d), $data);
	}

	/**
	 * @param array $data
	 * @return ContainerValidationResult
	 */
	public function validate(array $data): ContainerValidationResult {
		$validationResults = array_map(fn (FormElement $element) => $element->validate($data), $this->elements);
		return new ContainerValidationResult(...$validationResults);
	}

	/**
	 * @param array $data
	 * @param bool $validate
	 * @return array
	 */
	public function render(array $data, bool $validate = false): array {
		return [
			'type' => 'container',
			'elements' => array_map(fn (FormElement $element) => $element->render($data, $validate), $this->elements)
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
