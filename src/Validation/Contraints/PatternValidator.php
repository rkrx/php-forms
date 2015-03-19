<?php
namespace Kir\Forms\Validation\Contraints;

use Kir\Forms\Validation\AbstractValidator;

class PatternValidator extends AbstractValidator {
	/** @var int */
	private $pattern;
	/** @var string */
	private $encoding;
	/** @var string[] */
	private $modifiers;

	/**
	 * @param string $pattern
	 * @param string[] $modifiers
	 * @param null $message
	 * @param string $encoding
	 */
	public function __construct($pattern = '.*', array $modifiers = ['u'], $message = null, $encoding = 'UTF-8') {
		parent::__construct($message, 'The provided input is not valid');
		$this->setType('pattern');
		$this->pattern = $pattern;
		$this->encoding = $encoding;
		$this->modifiers = $modifiers;
	}

	/**
	 * @return int
	 */
	public function getPattern() {
		return $this->pattern;
	}

	/**
	 * @param int $pattern
	 * @return $this
	 */
	public function setPattern($pattern) {
		$this->pattern = $pattern;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getEncoding() {
		return $this->encoding;
	}

	/**
	 * @param string $encoding
	 * @return $this
	 */
	public function setEncoding($encoding) {
		$this->encoding = $encoding;
		return $this;
	}

	/**
	 * @return \string[]
	 */
	public function getModifiers() {
		return $this->modifiers;
	}

	/**
	 * @param \string[] $modifiers
	 * @return $this
	}
*/
	public function setModifiers($modifiers) {
		$this->modifiers = $modifiers;
		return $this;
	}

	/**
	 * @return array
	 */
	public function asArray() {
		$data = parent::asArray();
		$data['pattern'] = $this->getPattern();
		$data['modifiers'] = $this->getModifiers();
		return $data;
	}

	/**
	 * @param int|float|string $value
	 * @return bool
	 */
	protected function doValidate($value) {
		$regexp = strtr($this->pattern, ['/' => '\\/']);
		$modifiers = join('', $this->modifiers);
		return (bool) preg_match("/{$regexp}/{$modifiers}", (string) $value);
	}
}