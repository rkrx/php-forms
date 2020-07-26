<?php
namespace Forms\Form\Filtering;

use PHPUnit\Framework\TestCase;

class TrimFilterTest extends TestCase {
	public function test__invoke() {
		$filter = new TrimFilter();
		$data = $filter(['root' => ['a' => "\ta\tb\nc\r\n"]], ['root', 'a']);
		self::assertEquals("a\tb\nc", $data['root']['a']);

		$filter = new TrimFilter();
		$data = $filter(['root' => ['b' => ' x ']], ['root', 'a']);
		self::assertEquals(['root' => ['b' => ' x ']], $data);
	}
}
