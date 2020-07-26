<?php
namespace Forms;

interface TextProvider {
	/**
	 * @param string $dict
	 * @param string $text
	 * @param array $args
	 * @return string
	 */
	public function __invoke(string $dict, string $text, array $args = []): string;

	/**
	 * @param string $dict
	 * @param string $text
	 * @param array $args
	 * @return string
	 */
	public function t(string $dict, string $text, array $args = []): string;

	/**
	 * @param string $dict
	 * @param string $text
	 * @param array $args
	 * @return string
	 */
	public function translate(string $dict, string $text, array $args = []): string;
}
