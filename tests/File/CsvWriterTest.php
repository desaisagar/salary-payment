<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use SSD\SalaryPayment\File\CsvWriter;

/**
 * Class CsvWriterTest
 */
class CsvWriterTest extends TestCase
{
    /**
     * File handle
     */
    protected $path;

    /**
     * Basic setup for the tests
     */
    public function setUp(): void
    {
        $this->path = __DIR__ . '/testcsv.csv';
    }

    /**
     * Test for csv writer
     */
    public function testWrite(): void
    {
        $csvWriter = new CsvWriter();
        $data= [
            [100],
        ];

        $csvWriter->write($this->path, $data);
        $this->assertEquals(trim(file_get_contents($this->path)), '100');
    }

    /**
     * Test with empty data
     */
    public function testWriteWithEmptyData(): void
    {

        $csvWriter = new CsvWriter();
        $data= [];

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Insufficient data to write csv file.');

        $csvWriter->write($this->path, $data);

    }

    /**
     * Clean up at the end
     */
    public function tearDown(): void
    {
        if (file_exists($this->path)) {
            unlink($this->path);
        }
    }
}