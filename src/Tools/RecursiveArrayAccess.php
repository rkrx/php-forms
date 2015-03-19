<?php
namespace Kir\Forms\Tools;

class RecursiveArrayAccess {
	/**
	 * @param array $data
	 * @param string[] $path
	 * @return bool
	 */
	static public function has(array $data, array $path) {
		return self::hasPath($data, $path);
	}

	/**
	 * @param array $data
	 * @param string[] $path
	 * @param mixed $default
	 * @return mixed
	 */
	static public function get(array $data, array $path, $default = null) {
		if (self::hasPath($data, $path)) {
			return self::getFromPath($data, $path);
		}
		return $default;
	}

	/**
	 * @param array $data
	 * @param string[] $path
	 * @param int $default
	 * @return int
	 */
	static public function getBool(array $data, array $path, $default = 0) {
		if (self::hasPath($data, $path)) {
			$result = self::getFromPath($data, $path);
			if(is_array($result)) {
				return false;
			}
			return (bool) (string) $result;
		}
		return $default;
	}

	/**
	 * @param array $data
	 * @param string[] $path
	 * @param int $default
	 * @return int
	 */
	static public function getInt(array $data, array $path, $default = 0) {
		if (self::hasPath($data, $path)) {
			$result = self::getFromPath($data, $path);
			if(is_array($result)) {
				return 0;
			}
			return (int) (string) $result;
		}
		return $default;
	}

	/**
	 * @param array $data
	 * @param string[] $path
	 * @param float $default
	 * @return float
	 */
	static public function getFloat(array $data, array $path, $default = 0.0) {
		if (self::hasPath($data, $path)) {
			$result = self::getFromPath($data, $path);
			if(is_array($result)) {
				return 0.0;
			}
			return (float) (string) $result;
		}
		return $default;
	}

	/**
	 * @param array $data
	 * @param string[] $path
	 * @param string $default
	 * @return string
	 */
	static public function getString(array $data, array $path, $default = '') {
		if (self::hasPath($data, $path)) {
			$result = self::getFromPath($data, $path);
			if(is_array($result)) {
				return '';
			}
			return (string) $result;
		}
		return $default;
	}

	/**
	 * @param array $data
	 * @param string[] $path
	 * @param array $default
	 * @return array
	 */
	static public function getArray(array $data, array $path, $default = array()) {
		if (self::hasPath($data, $path)) {
			$result = self::getFromPath($data, $path);
			if(!is_array($result)) {
				return array();
			}
			return $result;
		}
		return $default;
	}

	/**
	 * @param array $data
	 * @param array $path
	 * @return $this
	 */
	static public function getNode(array $data, array $path) {
		$array = self::getArray($data, $path);
		return new static($array);
	}

	/**
	 * @param array $data
	 * @param string[] $path
	 * @return static[]
	 */
	static public function getChildren(array $data, array $path) {
		$result = array();
		$array = self::getArray($data, $path);
		foreach($array as $key => $value) {
			$result[$key] = new static($value);
		}
		return $result;
	}

	/**
	 * @param array $data
	 * @param string[] $path
	 * @param mixed $value
	 * @return array
	 */
	static public function set(array $data, array $path, $value) {
		$data = self::setAsPath($data, $path, $value);
		return $data;
	}

	/**
	 * @param string[] $data
	 * @param array $path
	 * @return bool
	 */
	static private function hasPath(array $data, array $path) {
		if (!count($path)) {
			return false;
		}
		$value = $data;
		while (count($path)) {
			$key = array_shift($path);
			if (!(is_array($value) && array_key_exists($key, $value))) {
				return false;
			}
			$value = $value[$key];
		}
		return true;
	}

	/**
	 * @param string[] $data
	 * @param array $path
	 * @return mixed
	 */
	static private function getFromPath(array $data, array $path) {
		$key = array_shift($path);
		$value = null;
		if (array_key_exists($key, $data)) {
			$value = $data[$key];
			if (count($path)) {
				if (is_array($value)) {
					$value = self::getFromPath($value, $path);
				} else {
					return null;
				}
			}
		}
		return $value;
	}

	/**
	 * @param string[] $data
	 * @param array $path
	 * @param mixed $value
	 * @return mixed
	 */
	static private function setAsPath(array $data, array $path, $value) {
		$key = array_shift($path);
		if (!array_key_exists($key, $data)) {
			$data[$key] = array();
		}
		if (count($path)) {
			$data[$key] = self::setAsPath($data[$key], $path, $value);
		} else {
			$data[$key] = $value;
		}
		return $data;
	}
}