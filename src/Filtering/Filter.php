<?php
namespace Kir\Forms\Filtering;

interface Filter {
	/**
	 * @param string $value
	 * @return string
	 */
	public function filter($value);
}