<?php
namespace Kir\Forms\Validation;

trait ValidatorAwareTrait {
	/** @var Validator[] */
	private $validators = [];

	/**
	 * @param Validator $validator
	 * @return $this
	 */
	public function addValidator(Validator $validator) {
		$this->validators[] = $validator;
		return $this;
	}

	/**
	 * @return Validator[]
	 */
	public function getValidators() {
		return $this->validators;
	}
}