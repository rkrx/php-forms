<?php
namespace Forms\Form\Filtering;

use Forms\Form\Common\RecursiveStructureAccessTrait;
use Forms\Form\Filtering\Abstractions\Filter;

/**
 * @see \Forms\Form\Filtering\CallbackFilterTest
 */
class CallbackFilter implements Filter {
	use RecursiveStructureAccessTrait;

	/** @var callable */
	private $fn;

	/**
	 * @param callable $fn
	 */
	public function __construct($fn) {
		$this->fn = $fn;
	}

	/**
	 * @param array $data
	 * @param string[] $keyPath
	 * @return array
	 */
	public function __invoke(array $data, array $keyPath): array {
		if(self::has($data, $keyPath)) {
			return call_user_func($this->fn, $data, $keyPath);
		}
		return $data;
	}
}
