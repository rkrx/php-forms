<?php
namespace Forms\Form\Filtering\Abstractions;

interface Filter {
	/**
	 * @param array $data
	 * @param string[] $keyPathPath
	 * @return array
	 */
	public function __invoke(array $data, array $keyPathPath): array;
}
