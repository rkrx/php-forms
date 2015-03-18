<?php
namespace Kir\Forms\Filtering\Filters;

use Kir\Forms\Filtering\Filter;

class TrimFilter implements Filter {
	/** @var null|string */
	private $characters;

	/**
	 * @param string|null $characters
	 */
	public function __construct($characters = null) {
		$this->characters = $characters;
	}

	/**
	 * @param string $value
	 * @return string
	 */
	public function filter($value) {
		if($this->characters === null) {
			return trim((string) $value);
		}
		return trim((string) $value, $this->characters);
	}
}