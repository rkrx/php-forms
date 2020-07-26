<?php
namespace Forms\Form\Filtering;

use PHPUnit\Framework\TestCase;

class NormalizeWhitespaceFilterTest extends TestCase {
	public function test__invoke() {
		$filter = new NormalizeWhitespaceFilter();
		$data = $filter(['root' => ['a' => "\ta\t  b \nc \r\n"]], ['root', 'a']);
		self::assertEquals(['root' => ['a' => ' a b c ']], $data);

		$filter = new NormalizeWhitespaceFilter();
		$data = $filter(['root' => ['b' => ' x ']], ['root', 'a']);
		self::assertEquals(['root' => ['b' => ' x ']], $data);
	}
}
