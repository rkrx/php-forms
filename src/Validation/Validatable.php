<?php
namespace Kir\Forms\Validation;


use Kir\Forms\Misc\MetaData;

interface Validatable {
	/**
	 * @param array $data
	 * @param MetaData $metaData
	 * @return ValidationResult
	 */
	public function validate(array $data, MetaData $metaData = null);
}