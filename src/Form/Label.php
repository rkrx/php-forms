<?php
namespace Forms\Form;

use Forms\Form\Abstractions\FormElement;

class Label extends Container {
	private string $title;

	public function __construct(string $title, array $attributes = [], FormElement ...$elements) {
		parent::__construct($attributes, ...$elements);
		$this->title = $title;
	}

	public function render(array $data, bool $validate = false): array {
		$fieldData = parent::render($data, $validate);
		$fieldData['type'] = 'label';
		$fieldData['title'] = $this->title;
		return $fieldData;
	}
}
