<?php
namespace Kir\Forms;

interface Renderable {
	/**
	 * @param array $data
	 * @param bool $validate
	 * @return array
	 */
	public function render(array $data, $validate = false);
}