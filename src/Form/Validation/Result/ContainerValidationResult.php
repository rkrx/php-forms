<?php

namespace Forms\Form\Validation\Result;

use ArrayIterator;
use Traversable;

class ContainerValidationResult implements ValidationResult {
	/** @var ValidationResult[] */
	private array $results;

	/**
	 * @param ValidationResult ...$results
	 */
	public function __construct(ValidationResult ...$results) {
		$this->results = $results;
	}

	/**
	 * @return bool
	 */
	public function isValid(): bool {
		foreach($this->getResults() as $result) {
			if(!$result->isValid()) {
				return false;
			}
		}
		return true;
	}

	/**
	 * @return ValidationResult[]
	 */
	public function getResults(): array {
		return $this->recurseInto($this->results);
	}

	/**
	 * @return string
	 */
	public function __toString(): string {
		$results = [];
		foreach($this->results as $result) {
			$results[] = (string) $result;
		}
		return implode("\n", $results);
	}

	/**
	 * @return Traversable|ValidationResult[]
	 */
	public function getIterator() {
		return new ArrayIterator($this->results);
	}

	/**
	 * @return array[]
	 */
	public function jsonSerialize() {
		$results = [];
		foreach($this->results as $result) {
			$results[] = [
				#'caption' => $result->getCaption(),
				'valid' => $result->isValid(),
				#'messages' => $result->getMessages()
			];
		}
		return $results;
	}

	/**
	 * @param ValidationResult[] $results
	 * @return array
	 */
	private function recurseInto(array $results): array {
		$elementResults = [];
		foreach($results as $result) {
			if($result instanceof ContainerValidationResult) {
				foreach($this->recurseInto($result->getResults()) as $elementResult) {
					$elementResults[] = $elementResult;
				}
			} elseif($result instanceof ElementValidationResult) {
				if(!$result->isValid()) {
					$elementResults[] = $result;
				}
			}
		}
		return $elementResults;
	}
}
