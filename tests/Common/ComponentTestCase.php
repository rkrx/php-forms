<?php
namespace Forms\Common;

use Forms\Form\Abstractions\AbstractInput;
use Forms\Form\Validation\Result\ValidationResult;
use PHPUnit\Framework\TestCase;

abstract class ComponentTestCase extends TestCase {
	abstract public function testConvert();
	abstract public function testValidate();
	abstract public function testRender();

	final protected function convertAndValidate(AbstractInput $input, array $data): ValidationResult {
		$convertedData = $input->convert($data);
		return $input->validate($convertedData);
	}

	final protected static function assertEq($actual, $expected) {
		self::assertEquals($expected, $actual);
	}

	abstract protected function getComp(): AbstractInput;
}
