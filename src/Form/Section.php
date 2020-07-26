<?php
namespace Forms\Form;

use Forms\Form\Abstractions\FormElement;

class Section extends Container {
	private string $title;

	/**
	 * @param string $title
	 * @param array $attributes
	 * @param FormElement ...$elements
	 */
	public function __construct(string $title, array $attributes = [], FormElement ...$elements) {
		parent::__construct($attributes, ...$elements);
		$this->title = $title;
	}

	/**
	 * @param array $data
	 * @param bool $validate
	 * @return array
	 */
	public function render(array $data, bool $validate = false): array {
		$fieldData = parent::render($data, $validate);
		$fieldData['type'] = 'section';
		$fieldData['title'] = $this->title;
		return $fieldData;
	}
}
