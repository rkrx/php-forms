<?php
namespace Forms\Form\Common;

use Forms\Form\Common\JSON\JSONException;
use \JsonException as BaseJsonException;

abstract class JSON {
	/**
	 * @param mixed|null $input
	 * @param bool $pretty
	 * @return string
	 */
	public static function stringify($input, bool $pretty = false): string {
		$options = JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_THROW_ON_ERROR;
		if($pretty) {
			$options |= JSON_PRETTY_PRINT;
		}
		return json_encode($input, $options);
	}

	/**
	 * @param string $input
	 * @param bool $assoc
	 * @return mixed|null
	 */
	public static function parse(string $input, bool $assoc = true) {
		try {
			return json_decode($input, $assoc, 512, JSON_THROW_ON_ERROR);
		} catch (BaseJsonException $e) {
			throw new JSONException($e->getMessage(), $e->getCode(), $e);
		}
	}
}
