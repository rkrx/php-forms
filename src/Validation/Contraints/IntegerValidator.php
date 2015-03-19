<?php
namespace Kir\Forms\Validation\Contraints;

class IntegerValidator extends PatternValidator {
	/**
	 * @param string|null $message
	 */
	public function __construct($message = null) {
		parent::__construct('^\\d+$', [], $message, 'ISO-8859-1');
		$this->setType('integer');
	}
}