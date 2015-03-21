<?php
namespace Kir\Forms\Validation\CollectionConstraints;

use Exception;
use Kir\Forms\Nodes\Node;
use Kir\Forms\Validation\AbstractCollectionValidator;

class MaxCountValidator extends AbstractCollectionValidator {
	/** @var int */
	private $maxCount;
	/** @var string */
	private $message;

	/**
	 * @param int $maxCount
	 * @param string $message
	 */
	public function __construct($maxCount = 1, $message = 'Requires a minimum of {count} nodes') {
		parent::__construct();
		$this->maxCount = $maxCount;
		$this->message = $message;
	}

	/**
	 * @return int
	 */
	public function getMaxCount() {
		return $this->maxCount;
	}

	/**
	 * @param int $minCount
	 * @return $this
	 */
	public function setMaxCount($minCount) {
		$this->maxCount = $minCount;
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
		if(count($data) > $this->maxCount) {
			$messages[] = strtr($this->message, ['{count}' => $this->maxCount]);
		}
		return $messages;
	}

	/**
	 * @return array
	 */
	public function asArray() {
		$data = [
			'maxCount' => $this->maxCount,
			'message' => $this->message,
		];
		return $data;
	}
}