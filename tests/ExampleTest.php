<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;

final class ExampleTest extends TestCase
{
	/**
	 * Example unit test
	 */
	public function testTest(): void
	{
		$this->assertTrue(true, "The truth is gone");
	}

	/**
	 * Test coding style fix
	 */
	public function testCodingStyle(): void
	{
		// File in the src/ folder
		$actual = dirname(__DIR__) . DIRECTORY_SEPARATOR . 'src' . DIRECTORY_SEPARATOR . 'File.php';
		// Matching file in the tests/data/ folder
		$expected = __DIR__ . DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR . 'Expected.php';

		$this->assertFileExists($actual);
		$this->assertFileExists($expected);
		$this->assertFileEquals($expected, $actual);
	}
}
