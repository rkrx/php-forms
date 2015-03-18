<?php
namespace Kir\Forms\Filtering;

abstract class AbstractEncodingAwareFilter implements Filter {
	/** @var string */
	private $encoding;

	/**
	 * @param string $encoding
	 */
	public function __construct($encoding = 'UTF-8') {
		$this->encoding = $encoding;
	}

	/**
	 * @return string
	 */
	protected function getEncoding() {
		return $this->encoding;
	}
}