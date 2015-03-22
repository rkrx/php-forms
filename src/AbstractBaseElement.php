<?php
namespace Kir\Forms;

use Kir\Forms\Nodes\Node;

class AbstractBaseElement implements Element {
	/** @var string */
	private $type;
	/** @var string */
	private $name = 'unknown';

	/**
	 * @param string|null $type
	 * @param string|null $name
	 */
	public function __construct($type = null, $name = null) {
		$this->type = $type;
		$this->name = $name;
	}

	/**
	 * @return string
	 */
	protected function getType() {
		return $this->type;
	}

	/**
	 * @param string $type
	 * @return $this
	 */
	protected function setType($type) {
		$this->type = $type;
		return $this;
	}

	/**
	 * @return null|string
	 */
	protected function getName() {
		return $this->name;
	}

	/**
	 * @param null|string $name
	 * @return $this
	 */
	protected function setName($name) {
		$this->name = $name;
		return $this;
	}

	/**
	 * @return Node
	 */
	public function build() {
		$type = $this->getType();
		$name = $this->getName();
		$node = new Node($type, $name);
		return $node;
	}
}