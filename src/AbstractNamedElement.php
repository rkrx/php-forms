<?php
namespace Kir\Forms;

abstract class AbstractNamedElement extends AbstractElement {
	/**
	 * @var string
	 */
	private $fieldName;

	/**
	 * @param string $type
	 * @param string $fieldName
	 */
	public function __construct($type, $fieldName) {
		parent::__construct($type);
		$this->fieldName = $fieldName;
	}

	/**
	 * @return string
	 */
	public function getFieldName() {
		return $this->fieldName;
	}
}