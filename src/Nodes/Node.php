<?php
namespace Kir\Forms\Nodes;

use ArrayIterator;
use Kir\Forms\Validation\Validator;

class Node {
	/** @var string */
	private $type = 'unknown';
	/** @var string */
	private $name = null;
	/** @var mixed */
	private $value = null;
	/** @var Node */
	private $parentNode = null;
	/** @var Node[] */
	private $nodes = [];
	/** @var mixed[] */
	private $attributes = [];
	/** @var bool */
	private $isValid = true;
	/** @var string[] */
	private $messages = [];
	/** @var Validator[] */
	private $validators;

	/**
	 * @param string $type
	 * @param string $fieldName
	 * @param Node $parentNode
	 */
	public function __construct($type, $fieldName, Node $parentNode = null) {
		$this->type = $type;
		$this->name = $fieldName;
		$this->parentNode = $parentNode;
	}

	/**
	 * @return string
	 */
	public function getType() {
		return $this->type;
	}

	/**
	 * @param string $type
	 * @return $this
	 */
	public function setType($type) {
		$this->type = $type;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getName() {
		return $this->name;
	}

	/**
	 * @param string $name
	 * @return $this
	 */
	public function setName($name) {
		$this->name = $name;
		return $this;
	}

	/**
	 * @return string[]
	 */
	public function getPath() {
		$path = [];
		if($this->parentNode !== null) {
			$path = $this->parentNode->getPath();
		}
		if($this->name !== null) {
			$path[] = $this->name;
		}
		return $path;
	}

	/**
	 * @return Node
	 */
	public function getParentNode() {
		return $this->parentNode;
	}

	/**
	 * @param Node $parentNode
	 * @return $this
	 */
	public function setParentNode($parentNode) {
		$this->parentNode = $parentNode;
		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getValue() {
		return $this->value;
	}

	/**
	 * @param mixed $value
	 * @return $this
	 */
	public function setValue($value) {
		$this->value = $value;
		return $this;
	}

	/**
	 * @return array
	 */
	public function getAttributes() {
		return $this->attributes;
	}

	/**
	 * @param array $attributes
	 * @return $this
	 */
	public function setAttributes(array $attributes) {
		$this->attributes = $attributes;
		return $this;
	}

	/**
	 * @param string $name
	 * @param mixed $default
	 * @return mixed
	 */
	public function getAttribute($name, $default = null) {
		if(array_key_exists($name, $this->attributes)) {
			return $this->attributes[$name];
		}
		return $default;
	}

	/**
	 * @param string $name
	 * @param mixed $value
	 * @return $this
	 */
	public function setAttribute($name, $value) {
		$this->attributes[$name] = $value;
		return $this;
	}

	/**
	 * @return boolean
	 */
	public function isValid() {
		return $this->isValid;
	}

	/**
	 * @param boolean $isValid
	 * @return $this
	 */
	public function setIsValid($isValid) {
		$this->isValid = (bool) $isValid;
		return $this;
	}

	/**
	 * @return string[]
	 */
	public function getMessages() {
		return $this->messages;
	}

	/**
	 * @param string[] $messages
	 * @return $this
	 */
	public function setMessages(array $messages) {
		foreach($messages as $message) {
			$this->addMessage($message);
		}
		return $this;
	}

	/**
	 * @param string $message
	 * @return $this
	 */
	public function addMessage($message) {
		$this->messages[] = (string) $message;
		return $this;
	}

	/**
	 * @return Validator[]
	 */
	public function getValidators() {
		return $this->validators;
	}

	/**
	 * @param Validator $validator
	 * @return $this
	 */
	public function addValidator(Validator $validator) {
		$this->validators[] = $validator;
		return $this;
	}

	/**
	 * @return Node[]
	 */
	public function getNodes() {
		return $this->nodes;
	}

	/**
	 * @return ArrayIterator|Node[]
	 */
	public function getIterator() {
		$it = new ArrayIterator();
		foreach($this->nodes as $child) {
			$it->append($child);
		}
		$it->rewind();
		return $it;
	}

	/**
	 * @param Node $node
	 * @return $this
	 */
	public function addNode(Node $node) {
		$this->nodes[] = $node;
		return $this;
	}

	/**
	 * @param Node $node
	 * @return bool
	 */
	public function removeNode(Node $node) {
		$result = false;
		$copy = $this->nodes;
		$this->nodes = [];
		foreach($copy as $childNode) {
			if($childNode !== $node) {
				$this->nodes[] = $childNode;
				$result = true;
			}
		}
		return $result;
	}

	/**
	 * @param bool $includeChildren
	 * @return array
	 */
	public function asArray($includeChildren = true) {
		$data = [];
		$data['type'] = $this->type;
		$data['name'] = $this->name;
		$data['attributes'] = $this->attributes;
		$data['valid'] = (bool) $this->isValid;
		$data['messages'] = $this->messages;
		$data['value'] = $this->value;
		if($includeChildren) {
			$data['nodes'] = [];
			foreach($this->nodes as $childNode) {
				$data['nodes'][] = $childNode->asArray($includeChildren);
			}
		}
		return $data;
	}
}