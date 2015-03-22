<?php
namespace Kir\Forms\Filtering\Filters;

use Kir\Forms\Filtering\Filter;

class ClosureFilter implements Filter {
	/** @var callable */
	private $fn;

	/**
	 * @param callable $fn
	 */
	public function __construct($fn) {
		$this->fn = $fn;
	}

	/**
	 * @param string $value
	 * @return string
	 */
	public function filter($value) {
		return call_user_func($this->fn, $value);
	}
}