<?php
namespace Kir\Forms\Validation;

interface ValidatorAware extends Validatable {
	public function addValidator();
}

