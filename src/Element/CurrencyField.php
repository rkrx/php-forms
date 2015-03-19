<?php
namespace Kir\Forms\Element;

use Kir\Forms\AbstractTextField;
use Kir\Forms\Misc\MetaData;
use Kir\Forms\Tools\RecursiveArrayAccess;

class CurrencyField extends AbstractTextField {
	/**
	 * @param array $data
	 * @param MetaData $metaData
	 * @return array
	 */
	public function convert(array $data, MetaData $metaData = null) {
		$data = parent::convert($data, $metaData);
		$fieldPath = $this->getFieldPath();
		if($metaData !== null) {
			$fieldPath = array_merge($metaData->getParentDataPath(), $fieldPath);
		}
		$value = RecursiveArrayAccess::getString($data, $fieldPath);
		# TODO: Locale
		$value = strtr($value, ['.' => '', ',' => '.']);
		$value = (float) $value;
		$data = RecursiveArrayAccess::set($data, $fieldPath, $value);
		return $data;
	}

	/**
	 * @param array $data
	 * @param bool $validate
	 * @param MetaData $metaData
	 * @return array
	 */
	public function render(array $data, $validate = false, MetaData $metaData = null) {
		$renderedData = parent::render($data, $validate, $metaData);
		$fieldPath = $this->getFieldPath();
		if($metaData !== null) {
			$fieldPath = array_merge($metaData->getParentDataPath(), $fieldPath);
		}
		$value = RecursiveArrayAccess::getFloat($data, $fieldPath);
		$value = number_format($value, 2, '.', '');
		$renderedData['value'] = $value;
		return $renderedData;
	}
}