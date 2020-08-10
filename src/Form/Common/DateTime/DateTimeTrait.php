<?php
namespace Forms\Form\Common\DateTime;

use DateTimeImmutable;
use DateTimeInterface;
use RuntimeException;
use Throwable;

trait DateTimeTrait {
	/**
	 * @param DateTimeInterface|string|mixed $input
	 * @return DateTimeImmutable
	 */
	protected function asDateTime($input): DateTimeImmutable {
		if($input instanceof DateTimeInterface) {
			return date_create_immutable($input->format('c'), $input->getTimezone());
		}
		if(is_string($input)) {
			try {
				return new DateTimeImmutable($input);
			} catch (Throwable $e) {
				throw new InvalidDateTimeException($e->getMessage(), $e->getCode(), $e);
			}
		}
		throw new RuntimeException('Invalid input');
	}
}
