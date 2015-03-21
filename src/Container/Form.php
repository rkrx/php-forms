<?php
namespace Kir\Forms\Container;

use Kir\Forms\AbstractContainer;
use Kir\Forms\Container;
use Kir\Forms\Element;
use Kir\Forms\Misc\MetaData;
use Kir\Forms\Nodes\Node;

class Form extends AbstractContainer {
	/**
	 * @param string|null $name
	 */
	function __construct($name = null) {
		parent::__construct('form', $name);
	}
}