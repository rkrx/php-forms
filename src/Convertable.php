<?php
namespace Kir\Forms;

use Kir\Forms\Misc\MetaData;

interface Convertable {
	/**
	 * @param array $data
	 * @param MetaData $metaData
	 * @return array
	 */
	public function convert(array $data, MetaData $metaData = null);
}