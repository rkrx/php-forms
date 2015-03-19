<?php
namespace Kir\Forms;

use Kir\Forms\Misc\MetaData;
use Kir\Forms\Tools\RecursiveArrayAccess;

abstract class AbstractNamedElement extends AbstractElement {
	/** @var string[] */
	private $fieldPath;

	/**
	 * @param array|string $fieldPath
	 */
	public function __construct($fieldPath) {
		parent::__construct();
		if(!is_array($fieldPath)) {
			$fieldPath = [(string) $fieldPath];
		}
		$this->fieldPath = $fieldPath;
	}

	/**
	 * @return string[]
	 */
	public function getFieldPath() {
		return $this->fieldPath;
	}

	/**
	 * @param array $data
	 * @param bool $validate
	 * @param MetaData $metaData
	 * @return array
	 */
	public function render(array $data, $validate = false, MetaData $metaData = null) {
		$renderedData = parent::render($data, $validate, $metaData);
		$dataPath = $this->getFullDataPath($metaData);
		$renderedData['name'] = $dataPath;
		$renderedData['value'] = '';
		if(RecursiveArrayAccess::has($data, $dataPath)) {
			$value = RecursiveArrayAccess::getString($data, $dataPath);
			$renderedData['value'] = $value;
		}
		if($validate) {
			$hasErrorMessages = $this->validate($data, $metaData)->hasErrorMessages();
			$renderedData['valid'] = !$hasErrorMessages;
		}
		return $renderedData;
	}

	/**
	 * @param MetaData $metaData
	 * @return string[]
	 */
	protected function getFullDataPath(MetaData $metaData = null) {
		$dataPath = $this->fieldPath;
		if($metaData !== null) {
			$dataPath = array_merge($metaData->getParentDataPath(), $dataPath);
		}
		return $dataPath;
	}
}