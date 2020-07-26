<?php
namespace Forms\Form\Common;

class RecursiveStructureAccess {
	/**
	 * @param array $data
	 * @param string[] $path
	 * @return bool
	 */
	public static function has(array $data, array $path): bool {
		$count = count($path);
		if (!$count) {
			return is_array($data);
		}
		foreach($path as $part) {
			if(is_array($data)) {
				if(!array_key_exists($part, $data)) {
					return false;
				}
				$data = $data[$part];
			} else {
				return false;
			}
		}
		return true;
	}

	/**
	 * @param array $data
	 * @param string[] $path
	 * @param mixed $default
	 * @return mixed
	 */
	public static function get(array $data, array $path, $default = null) {
		$count = count($path);
		if (!$count) {
			return $default;
		}
		foreach($path as $part) {
			if(is_array($data)) {
				if(!array_key_exists($part, $data)) {
					return $default;
				}
				$data = $data[$part];
			} else {
				return $default;
			}
		}
		return $data;
	}

	/**
	 * @param array $data
	 * @param string[] $path
	 * @param mixed $value
	 * @return array
	 */
	public static function set(array $data, array $path, $value): array {
		$struct = &$data;
		while(count($path)) {
			$key = array_shift($path);
			if(!array_key_exists($key, $struct) || !is_array($struct[$key])) {
				$struct[$key] = [];
			}
			$struct = &$struct[$key];
			if(!count($path)) {
				$struct = $value;
			}
		}
		return $data;
	}

	/**
	 * @param array $data
	 * @param array $path
	 * @param mixed $default
	 * @param callable $fn
	 * @return array
	 */
	public static function modify(array $data, array $path, $default, $fn): array {
		return self::set($data, $path, $fn(self::get($data, $path, $default)));
	}

	/**
	 * @param array $data
	 * @param string[] $path
	 * @return array
	 */
	public static function remove(array $data, array $path): array {
		$struct = &$data;
		while(count($path)) {
			$key = array_shift($path);
			if(!array_key_exists($key, $struct)) {
				return $data;
			}
			if(count($path) && is_array($struct[$key])) {
				$struct = &$struct[$key];
				continue;
			}
			unset($struct[$key]);
		}
		return $data;
	}
}
