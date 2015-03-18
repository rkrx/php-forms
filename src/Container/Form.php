<?php
namespace Kir\Forms\Container;

use Kir\Forms\AbstractContainer;
use Kir\Forms\Container;
use Kir\Forms\Element;

class Form extends AbstractContainer {
	public function render(array $data, $validate = false) {
		$data = parent::render($data, $validate);
		$data['type'] = 'form';
		return $data;
	}
}