<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use SSD\SalaryPayment\Services\{
    DateCalculatorService,
    ReportService
};
use SSD\SalaryPayment\File\{
    FileWriterInterface,
    CsvWriter
};

/**
 * Class ReportServiceTest
 */
class ReportServiceTest extends TestCase
{
    /**
     * Day calculator service mock
     *
     * @var \Mockery\MockInterface
     */
    protected $dayCalculatorServiceMock;

    /**
     * File writer interface mock
     *
     * @var \Mockery\MockInterface
     */
    protected $fileWriterInterfaceMock;

    /**
     * Basic setup
     */
    public function setUp(): void
    {
        $this->dayCalculatorServiceMock = Mockery::mock(DateCalculatorService::class);
        $this->fileWriterInterfaceMock = Mockery::mock(CsvWriter::class, FileWriterInterface::class);
    }

    /**
     * Test generate report
     */
    public function testGenerate(): void
    {
        $filename = 'testcsv.csv';

        $months = [
            new \DateTime('1 February 2019')
        ];

        $this->dayCalculatorServiceMock->shouldReceive('getMonthsUntilNewYear')
            ->once()
            ->withNoArgs()
            ->andReturn($months);

        $this->fileWriterInterfaceMock->shouldReceive('write')
            ->once()
            ->with(Mockery::on(function ($argument) {
                return is_string($argument);
            }),
            Mockery::on(function ($argument) {
                return is_array($argument) && !empty($argument);
            }));

        $reportService = new ReportService($this->dayCalculatorServiceMock, $this->fileWriterInterfaceMock);
        $result = $reportService->generate($filename);
        $this->assertNull($result);
    }
}