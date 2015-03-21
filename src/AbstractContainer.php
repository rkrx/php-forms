<?php
namespace Kir\Forms;

use Kir\Forms\Nodes\Node;
use Kir\Forms\Validation\CollectionValidator;

abstract class AbstractContainer implements Container {
	/** @var Element[] */
	private $elements = [];
	/** @var string|null */
	private $type = null;
	/** @var string|null */
	private $name = null;
	/** @var CollectionValidator[] */
	private $validators = [];

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
	 * @return CollectionValidator[]
	 */
	public function getValidators() {
		return $this->validators;
	}

	/**
	 * @param CollectionValidator $validator
	 * @return $this
	 */
	public function addValidator(CollectionValidator $validator) {
		$this->validators[] = $validator;
		return $this;
	}

	/**
	 * @param Element $element
	 * @return $this
	 */
	public function add(Element $element) {
		$this->elements[] = $element;
		return $this;
	}

	/**
	 * @return Element[]
	 */
	protected function getChildren() {
		return $this->elements;
	}

	/**
	 * @return Node
	 */
	public function build() {
		$node = $this->buildNode();
		foreach($this->elements as $element) {
			$childNode = $element->build();
			$childNode->setParentNode($childNode);
			$node->addNode($childNode);
		}
		foreach($this->validators as $validator) {
			$node->addValidator($validator);
		}
		return $node;
	}

	/**
	 * @return Node
	 */
	protected function buildNode() {
		$type = $this->getType();
		$name = $this->getName();
		$node = new Node($type, $name);
		return $node;
	}
}