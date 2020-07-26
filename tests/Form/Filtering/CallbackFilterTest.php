<?php
namespace Forms\Form\Filtering;

use Forms\Form\Common\RecursiveStructureAccess;
use PHPUnit\Framework\TestCase;

/**
 * @see \Forms\Form\Filtering\CallbackFilter
 * @package Forms\Form\Filtering
 */
class CallbackFilterTest extends TestCase {
	public function test__invoke() {
		$filter = new CallbackFilter(fn (array $data, array $keyPath) => RecursiveStructureAccess::modify($data, $keyPath, null, 'trim'));
		$data = $filter(['root' => ['a' => "\tx\n"]], ['root', 'a']);
		self::assertEquals(['root' => ['a' => 'x']], $data);

		$filter = new CallbackFilter(fn (array $data, array $keyPath) => RecursiveStructureAccess::modify($data, $keyPath, null, 'trim'));
		$data = $filter(['root' => ['b' => "\tx\n"]], ['root', 'a']);
		self::assertEquals(['root' => ['b' => "\tx\n"]], $data);
	}
}
