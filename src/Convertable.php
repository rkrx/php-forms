<?php
namespace Kir\Forms;

interface Convertable {
	/**
	 * @param array $data
	 * @return array
	 */
	public function convert(array $data);
}