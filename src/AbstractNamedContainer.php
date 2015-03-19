<?php
namespace Kir\Forms;

use Kir\Forms\Misc\MetaData;

class AbstractNamedContainer extends AbstractContainer {
	/** @var string[] */
	private $dataPath;

	/**
	 * @param array|string $dataPath
	 */
	function __construct($dataPath) {
		if(!is_array($dataPath)) {
			$dataPath = [(string) $dataPath];
		}
		$this->dataPath = $dataPath;
	}

	/**
	 * @return string[]
	 */
	public function getDataPath() {
		return $this->dataPath;
	}

	/**
	 * @param array $data
	 * @param bool $validate
	 * @param MetaData $metaData
	 * @return array
	 */
	public function render(array $data, $validate = false, MetaData $metaData = null) {
		$renderedData = parent::render($data, $validate, $metaData);
		#$renderedData = array_merge(['name' => $this->dataPath], $renderedData);
		return $renderedData;
	}
}