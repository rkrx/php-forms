<?php
namespace Kir\Forms;

use Kir\Forms\Tools\EventHandler;
use Kir\Forms\Validation\ValidationResult;
use Kir\Forms\Validation\Validator;

abstract class AbstractElement extends AbstractBaseElement {
	/** @var Validator[] */
	private $validators = [];

	/**
	 * @param string|null $type
	 * @param string|null $name
	 */
	public function __construct($type = null, $name = null) {
		parent::__construct($type, $name);
		$this->eventHandler = new EventHandler();
	}

	/**
	 * @return EventHandler
	 */
	public function getEventHandler() {
		return $this->eventHandler;
	}

	/**
	 * @return Validator[]
	 */
	public function getValidators() {
		return $this->validators;
	}

	/**
	 * @param Validator $validator
	 * @return $this
	 */
	public function addValidator(Validator $validator) {
		$this->validators[] = $validator;
		return $this;
	}

	/**
	 * @param array $data
	 * @return array
	 */
	public function convert(array $data) {
		return $data;
	}

	/**
	 * @param mixed $value
	 * @return string[]
	 */
	public function validate($value) {
		return new ValidationResult();
	}

	/**
	 * @return array
	 */
	public function build() {
		$node = parent::build();
		foreach($this->getValidators() as $validator) {
			$node->addValidator($validator);
		}
		return $node;
	}
}