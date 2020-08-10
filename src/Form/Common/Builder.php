<?php
namespace Forms\Form\Common;

class Builder {
	public static function attr(array $attr, string $key, callable $fn) {
		if(array_key_exists($key, $attr)) {
			$fn($attr[$key]);
		}
	}

	public static function attrs(array $attr, array $fns) {
		foreach($fns as $key => $fn) {
			if(array_key_exists($key, $attr)) {
				$fn($attr[$key]);
			}
		}
	}
}
