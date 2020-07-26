<?php
namespace Forms;

class OfficeTextProvider implements TextProvider {
	/**
	 * @param string $dict
	 * @param string $text
	 * @param array $args
	 * @return string
	 */
	public function __invoke(string $dict, string $text, array $args = []): string {
		return $this->translate($dict, $text, $args);
	}

	/**
	 * @param string $dict
	 * @param string $text
	 * @param array $args
	 * @return string
	 */
	public function t(string $dict, string $text, array $args = []): string {
		return $this->translate($dict, $text, $args);
	}

	/**
	 * @param string $dict
	 * @param string $text
	 * @param array $args
	 * @return string
	 */
	public function translate(string $dict, string $text, array $args = []): string {
		$result = $text; // TODO: Load actual translated text-phrases
		if(strpos($result, '{') === false) {
			return (string) $result;
		}
		$substitutes = [];
		foreach($args as $key => $value) {
			$substitutes["{{$key}}"] = $value;
		}
		return strtr($result, $substitutes);
	}
}
