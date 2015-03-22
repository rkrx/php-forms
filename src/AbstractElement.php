<?php
namespace Kir\Forms;

use Kir\Forms\Tools\EventHandler;
use Kir\Forms\Validation\Validator;

abstract class AbstractElement extends AbstractBaseElement {
	/** @var Validator[] */
	private $validators = [];

	/**
	 */
	public function __construct() {
		$this->eventHandler = new EventHandler();
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