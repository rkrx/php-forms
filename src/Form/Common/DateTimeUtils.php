<?php
namespace Forms\Form\Common;

use DateTimeImmutable;
use DateTimeInterface;

abstract class DateTimeUtils {
	/**
	 * @param DateTimeInterface|InvalidValue|string|null $input
	 * @return DateTimeImmutable|InvalidValue|null
	 */
	public static function getDateTimeImmutable($input) {
		if($input === null) {
			return null;
		}
		if($input instanceof DateTimeInterface) {
			return date_create_immutable($input->format('c'));
		}
		if($input instanceof InvalidValue) {
			return $input;
		}
		if(trim($input) === '') {
			return null;
		}
		if(is_string($input)) {
			$dt = date_create_immutable($input);
			if($dt !== false) {
				return $dt;
			}
		}
		return new InvalidValue($input);
	}
}
