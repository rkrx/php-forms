<?php
namespace Kir\Forms;

use Kir\Forms\Misc\MetaData;

interface Renderable {
	/**
	 * @param array $renderedData
	 * @param bool $validate
	 * @param MetaData $metaData
	 * @return array
	 */
	public function render(array $renderedData, $validate = false, MetaData $metaData = null);
}