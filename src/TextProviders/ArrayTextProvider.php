<?php
namespace Forms\TextProviders;

use Forms\Form\Common\RecursiveStructureAccessTrait;
use Forms\TextProvider;

class ArrayTextProvider implements TextProvider {
	use RecursiveStructureAccessTrait;

	private array $source;

	/**
	 * @param array $source
	 */
	public function __construct(array $source) {
		$this->source = $source;
	}

	/**
	 * @inheritDoc
	 */
	public function __invoke(string $dict, string $text, array $args = []): string {
		return $this->translate($dict, $text, $args);
	}

	/**
	 * @inheritDoc
	 */
	public function t(string $dict, string $text, array $args = []): string {
		return $this->translate($dict, $text, $args);
	}

	/**
	 * @inheritDoc
	 */
	public function translate(string $dict, string $text, array $args = []): string {
		$result = self::getString($this->source, [$dict, $text]);
		if($result === null) {
			return '';
		}
		if(strpos($result, '{') !== false) {
			$replaceKeys = [];
			foreach($args as $key => $value) {
				$replaceKeys["{{$key}}"] = $value;
			}
			$result = strtr($result, $replaceKeys);
		}
		return $result;
	}
}
