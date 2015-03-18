<?php
namespace Kir\Forms\Container;

use Kir\Forms\AbstractContainer;

class Repeat extends AbstractContainer {
	/** @var string */
	private $keyName;

	/**
	 * @param string $keyName
	 */
	public function __construct($keyName) {
		$this->keyName = $keyName;
	}

	/**
	 * @param array $data
	 * @return array
	 */
	public function convert(array $data) {
		if(array_key_exists($this->keyName, $data)) {
			$items = $data[$this->keyName];
			foreach($items as $key => &$item) {
				foreach($this->getChildren() as $element) {
					$item = $element->convert($item);
				}
			}
			$data[$this->keyName] = $items;
		}
		return $data;
	}

	/**
	 * @param array $data
	 * @param bool $validate
	 * @return array
	 */
	public function render(array $data, $validate = false) {
		$renderedData = [
			'type' => 'repeat',
			'children' => [],
			'valid' => false
		];
		if(array_key_exists($this->keyName, $data)) {
			$items = $data[$this->keyName];
			foreach($items as $key => $item) {
				$children = [];
				foreach($this->getChildren() as $element) {
					$children[] = $element->render($item, $validate);
					if($validate) {
						$validationResult = $element->validate($item);
						$renderedData['valid'] = $renderedData['valid'] && $validationResult->hasErrorMessages();
					}
				}
				$renderedData['children'][$key] = $children;
			}
		}
		return $renderedData;
	}
}