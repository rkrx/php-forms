<?php
namespace Forms;

use Forms\Form\Abstractions\AbstractContainerElement;

class Form extends AbstractContainerElement {
	/**
	 * @param array $data
	 * @param bool $validate
	 * @return array
	 */
	public function render(array $data, bool $validate = false): array {
		$data = parent::render($data, $validate);
		$data['type'] = 'form';
		return $data;
	}
}
