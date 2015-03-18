<?php
namespace Kir\Forms\Filtering\Filters;

use Kir\Forms\Filtering\AbstractEncodingAwareFilter;

class LowerCaseFilter extends AbstractEncodingAwareFilter {
	/**
	 * @param string $value
	 * @return string
	 */
	public function filter($value) {
		return mb_convert_case((string) $value, MB_CASE_LOWER, $this->getEncoding());
	}
}