<?php
namespace Kir\Forms;

use Kir\Forms\Misc\MetaData;
use Kir\Forms\Tools\EventHandler;
use Kir\Forms\Validation\ValidationResult;

abstract class AbstractElement implements Element {
	/** @var string */
	private $type;
	/** @var EventHandler */
	private $eventHandler;

	/**
	 */
	public function __construct() {
		$this->eventHandler = new EventHandler();
	}

	/**
	 * @return string
	 */
	public function getType() {
		return $this->type;
	}

	/**
	 * @param string $type
	 * @return $this
	 */
	public function setType($type) {
		$this->type = $type;
		return $this;
	}

	/**
	 * @param array $data
	 * @param MetaData $metaData
	 * @return array
	 */
	public function convert(array $data, MetaData $metaData = null) {
		return $data;
	}

	/**
	 * @param array $data
	 * @param MetaData $metaData
	 * @return ValidationResult
	 */
	public function validate(array $data, MetaData $metaData = null) {
		return new ValidationResult();
	}

	/**
	 * @param array $renderedData
	 * @param bool $validate
	 * @param MetaData $metaData
	 * @return array
	 */
	public function render(array $renderedData, $validate = false, MetaData $metaData = null) {
		$renderedData = [];
		$renderedData['type'] = $this->type;
		return $renderedData;
	}

	/**
	 * @return EventHandler
	 */
	protected function getEventHandler() {
		return $this->eventHandler;
	}
}