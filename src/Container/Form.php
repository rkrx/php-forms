<?php
namespace Kir\Forms\Container;

use Kir\Forms\AbstractContainer;
use Kir\Forms\Container;
use Kir\Forms\Element;
use Kir\Forms\Misc\MetaData;

class Form extends AbstractContainer {
	/**
	 */
	function __construct() {
		parent::__construct();
		$this->setType('form');
	}

	/**
	 * @param array $renderedData
	 * @param bool $validate
	 * @param MetaData $metaData
	 * @return array
	 */
	public function render(array $renderedData, $validate = false, MetaData $metaData = null) {
		$renderedData = parent::render($renderedData, $validate, $metaData);
		$renderedData['type'] = 'form';
		return $renderedData;
	}
}