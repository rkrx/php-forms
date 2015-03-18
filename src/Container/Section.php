<?php
namespace Kir\Forms\Container;

use Kir\Forms\AbstractContainer;

class Section extends AbstractContainer {
	public function render(array $data, $validate = false) {
		$data = parent::render($data, $validate);
		$data['type'] = 'section';
		return $data;
	}
}