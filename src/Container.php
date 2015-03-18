<?php
namespace Kir\Forms;

interface Container extends Element {
	/**
	 * @param Element $element
	 * @return $this
	 */
	public function add(Element $element);
}