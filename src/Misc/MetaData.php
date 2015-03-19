<?php
namespace Kir\Forms\Misc;

class MetaData {
	/**
	 * @var string[]
	 */
	private $parentDataPath = [];

	/**
	 * @return string[]
	 */
	public function getParentDataPath() {
		return $this->parentDataPath;
	}

	/**
	 * @param string[] $parentDataPath
	 * @return $this
	 */
	public function setParentDataPath($parentDataPath) {
		$this->parentDataPath = $parentDataPath;
		return $this;
	}
}