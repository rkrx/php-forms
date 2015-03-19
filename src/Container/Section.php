<?php
namespace Kir\Forms\Container;

use Kir\Forms\AbstractContainer;
use Kir\Forms\Misc\MetaData;

class Section extends AbstractContainer {
	/**
	 */
	function __construct() {
		parent::__construct();
		$this->setType('section');
	}

	/**
	 * @param array $renderedData
	 * @param bool $validate
	 * @param MetaData $metaData
	 * @return array
	 */
	public function render(array $renderedData, $validate = false, MetaData $metaData = null) {
		$renderedData = parent::render($renderedData, $validate, $metaData);
		$renderedData['type'] = 'section';
		return $renderedData;
	}
}