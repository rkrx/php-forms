<?php
namespace Kir\Forms\Validation\CollectionConstraints;

use Exception;
use Kir\Forms\Nodes\Node;
use Kir\Forms\Validation\AbstractCollectionValidator;

class MinCountValidator extends AbstractCollectionValidator {
	/** @var int */
	private $minCount;
	/** @var string */
	private $message;

	/**
	 * @param int $minCount
	 * @param string $message
	 */
	public function __construct($minCount = 1, $message = 'Requires a minimum of {count} nodes') {
		parent::__construct();
		$this->minCount = $minCount;
		$this->message = $message;
	}

	/**
	 * @return int
	 */
	public function getMinCount() {
		return $this->minCount;
	}

	/**
	 * @param int $minCount
	 * @return $this
	 */
	public function setMinCount($minCount) {
		$this->minCount = $minCount;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getMessage() {
		return $this->message;
	}

	/**
	 * @param string $message
	 * @return $this
	 */
	public function setMessage($message) {
		$this->message = $message;
		return $this;
	}

	/**
	 * @param array $data
	 * @param Node $node
	 * @return string[]
	 * @throws Exception
	 */
	public function validate($data, Node $node) {
		$messages = parent::validate($data, $node);
		if(count($data) < $this->minCount) {
			$messages[] = strtr($this->message, ['{count}' => $this->minCount]);
		}
		return $messages;
	}

	/**
	 * @return array
	 */
	public function asArray() {
		$data = [
			'minCount' => $this->minCount,
			'message' => $this->message,
		];
		return $data;
	}
}