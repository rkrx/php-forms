<?php
namespace Forms\Form\Common;

trait RecursiveStructureAccessTrait {
	/**
	 * @param array $data
	 * @param array $path
	 * @return bool
	 */
	final protected static function has(array $data, array $path): bool {
		return RecursiveStructureAccess::has($data, $path);
	}

	/**
	 * @param array $data
	 * @param array $path
	 * @return bool
	 */
	final protected static function isInvalidValue(array $data, array $path) {
		return self::get($data, $path) instanceof InvalidValue;
	}

	/**
	 * @param array $data
	 * @param array $path
	 * @param mixed $default
	 * @return mixed
	 */
	final protected static function get(array $data, array $path, $default = null) {
		return RecursiveStructureAccess::get($data, $path, $default);
	}

	/**
	 * @param array $data
	 * @param array $path
	 * @param string|null $default
	 * @return string|null
	 */
	final protected static function getString(array $data, array $path, ?string $default = ''): ?string {
		if(self::has($data, $path)) {
			$value = RecursiveStructureAccess::get($data, $path, $default);
			if(is_scalar($value) || (is_object($value) && method_exists($value, '__toString'))) {
				return (string) $value;
			}
			return '';
		}
		return $default;
	}

	/**
	 * @param array $data
	 * @param array $path
	 * @param string|null $default
	 * @return string|null
	 */
	final protected static function getTrimmedString(array $data, array $path, ?string $default = ''): ?string {
		return trim(self::getString($data, $path, $default));
	}

	/**
	 * @param array $data
	 * @param array $path
	 * @param mixed $value
	 * @return mixed
	 */
	final protected static function set(array $data, array $path, $value) {
		return RecursiveStructureAccess::set($data, $path, $value);
	}

	/**
	 * @param array $data
	 * @param array $path
	 * @return array
	 */
	final protected static function remove(array $data, array $path): array {
		return RecursiveStructureAccess::remove($data, $path);
	}
}
