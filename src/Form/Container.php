<?php
namespace Forms\Form;

use Forms\Form\Abstractions\AbstractContainerElement;
use Forms\Form\Abstractions\FormElement;

class Container extends AbstractContainerElement {
	private array $attributes;

	/**
	 * @param array $attributes
	 * @param FormElement ...$elements
	 */
	public function __construct(array $attributes = [], FormElement ...$elements) {
		parent::__construct(...$elements);
		$this->attributes = $attributes;
	}

	/**
	 * @return array
	 */
	public function getAttributes(): array {
		return $this->attributes;
	}

	/**
	 * @param string $attribute
	 * @param string $value
	 * @return $this
	 */
	public function setAttribute(string $attribute, string $value) {
		$this->attributes[$attribute] = $value;
		return $this;
	}

	/**
	 * @param array $attributes
	 * @return $this
	 */
	public function setAttributes(array $attributes) {
		$this->attributes = $attributes;
		return $this;
	}

	/**
	 * @param array $data
	 * @param bool $validate
	 * @return array
	 */
	public function render(array $data, bool $validate = false): array {
		$fieldData = parent::render($data, $validate);
		$fieldData['attributes'] = $this->attributes;
		return $fieldData;
	}
}
