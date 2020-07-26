<?php
namespace Forms\Form\Filtering;

use Forms\Form\Common\RecursiveStructureAccessTrait;
use Forms\Form\Filtering\Abstractions\Filter;

/**
 * Collapses all non-visible characters to a single white-space-character
 */
class NormalizeWhitespaceFilter implements Filter {
	use RecursiveStructureAccessTrait;

	/**
	 * @param array $data
	 * @param string[] $keyPathPath
	 * @return array
	 */
	public function __invoke(array $data, array $keyPathPath): array {
		if(self::has($data, $keyPathPath)) {
			$value = self::get($data, $keyPathPath);
			if(is_scalar($value)) {
				$data = self::set($data, $keyPathPath, preg_replace('/\\s+/', ' ', $value));
			}
		}
		return $data;
	}
}
