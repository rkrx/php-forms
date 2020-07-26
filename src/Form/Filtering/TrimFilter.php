<?php
namespace Forms\Form\Filtering;

use Forms\Form\Common\RecursiveStructureAccess;
use Forms\Form\Filtering\Abstractions\Filter;

class TrimFilter implements Filter {
	/** @var string|null */
	private ?string $trimCharacters;

	public function __construct(?string $trimCharacters = null) {
		$this->trimCharacters = $trimCharacters;
	}

	/**
	 * @param array $data
	 * @param string[] $keyPathPath
	 * @return array
	 */
	public function __invoke(array $data, array $keyPathPath): array {
		if(RecursiveStructureAccess::has($data, $keyPathPath)) {
			$value = RecursiveStructureAccess::get($data, $keyPathPath);
			if(is_scalar($value)) {
				if($this->trimCharacters !== null) {
					$value = trim($value, $this->trimCharacters);
				} else {
					$value = trim($value);
				}
				$data = RecursiveStructureAccess::set($data, $keyPathPath, $value);
			}
		}
		return $data;
	}
}
