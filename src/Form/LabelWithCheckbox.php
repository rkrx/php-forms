<?php
namespace Forms\Form;

use Forms\Form\Abstractions\FormElement;

class LabelWithCheckbox extends Container {
	private Checkbox $checkbox;
	private string $title;

	/**
	 * @param array $fieldNamePath
	 * @param string $title
	 * @param array $attributes
	 * @param FormElement ...$elements
	 */
	public function __construct(array $fieldNamePath, string $title, array $attributes = [], FormElement ...$elements) {
		parent::__construct($attributes, ...$elements);
		$this->checkbox = new Checkbox($fieldNamePath, $title, $attributes['checkbox'] ?? []);
		$this->title = $title;
	}

	public function render(array $data, bool $validate = false): array {
		$fieldData = parent::render($data, $validate);
		$fieldData['checkbox'] = $this->checkbox->render($data, $validate);
		$fieldData['type'] = 'label-with-checkbox';
		$fieldData['title'] = $this->title;
		return $fieldData;
	}
}
