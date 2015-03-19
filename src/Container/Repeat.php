<?php
namespace Kir\Forms\Container;

use Kir\Forms\AbstractNamedContainer;
use Kir\Forms\Misc\MetaData;
use Kir\Forms\Tools\RecursiveArrayAccess;

class Repeat extends AbstractNamedContainer {
	/**
	 * @param array|string $dataPath
	 */
	function __construct($dataPath) {
		parent::__construct($dataPath);
		$this->setType('repeat');
	}

	/**
	 * @param array $data
	 * @return array
	 */
	public function convert(array $data) {
		$dataPath = $this->getDataPath();
		if(RecursiveArrayAccess::has($data, $dataPath)) {
			$items = RecursiveArrayAccess::getArray($data, $dataPath);
			foreach($items as $key => &$item) {
				foreach($this->getChildren() as $element) {
					$item = $element->convert($item);
				}
			}
			$data = RecursiveArrayAccess::set($data, $dataPath, $items);
		}
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
		$renderedData['type'] = 'repeat';
		$renderedData['children'] = [];
		$renderedData['valid'] = true;
		$dataPath = $this->getDataPath();
		if($metaData !== null) {
			$dataPath = array_merge($dataPath, $metaData->getParentDataPath());
		}
		if(RecursiveArrayAccess::has($data, $dataPath)) {
			$items = RecursiveArrayAccess::getArray($data, $dataPath);
			foreach($items as $key => $item) {
				$children = [];
				foreach($this->getChildren() as $element) {
					$childMetaData = new MetaData();
					$childDataPath = array_merge($dataPath, [$key]);
					$childMetaData->setParentDataPath($childDataPath);
					$children[] = $element->render($data, $validate, $childMetaData);
					if($validate) {
						$validationResult = $element->validate($item);
						$hasErrorMessages = $validationResult->hasErrorMessages();
						$hasInnerErrors = $validationResult->hasInnerErrors();
						$renderedData['valid'] = $renderedData['valid'] && (!$hasErrorMessages && $hasInnerErrors);
					}
				}
				$renderedData['children'][$key] = $children;
			}
		}
		return $renderedData;
	}
}