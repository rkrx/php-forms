<?php
namespace Kir\Forms;

use Kir\Forms\Nodes\Node;
use Kir\Forms\Validation\CollectionValidator;

abstract class AbstractContainer extends AbstractBaseElement {
	/** @var Element[] */
	private $elements = [];
	/** @var CollectionValidator[] */
	private $validators = [];

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
		$node = parent::build();
		foreach($this->elements as $element) {
			$childNode = $element->build();
			$childNode->setParentNode($childNode);
			$node->addNode($childNode);
		}
		foreach($this->getValidators() as $validator) {
			$node->addValidator($validator);
		}
		return $node;
	}
}