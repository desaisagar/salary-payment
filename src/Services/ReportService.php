<?php
declare(strict_types=1);

namespace SSD\SalaryPayment\Services;

use SSD\SalaryPayment\File\FileWriterInterface;

/**
 * Class payment service
 */
class ReportService
{
    /**
     * Report directory
     */
    const DIRECTORY_REPORT = 'data';

    /**
     * @var DateCalculatorService
     */
    protected $dayCalculatorService;

    /**
     * @var FileWriterInterface
     */
    protected $fileWriterService;

    /**
     * ReportService constructor.
     *
     * @param DateCalculatorService $dayCalculatorService
     * @param FileWriterInterface $fileWriter
     */
    public function __construct(DateCalculatorService $dayCalculatorService, FileWriterInterface $fileWriter)
    {
        $this->dayCalculatorService = $dayCalculatorService;
        $this->fileWriterService = $fileWriter;
    }

    /**
     * Generate report
     *
     * @param string $filename
     */
    public function generate(string $filename): void
    {
        $data[] = $this->getHeaders();

        $directoryPath = PROJECT_ROOT . DIRECTORY_SEPARATOR . self::DIRECTORY_REPORT;
        if (!is_dir($directoryPath)) {
            mkdir($directoryPath);
        }

        $filePath = $directoryPath . DIRECTORY_SEPARATOR . $filename;
        $salaryPaymentDates = $this->dayCalculatorService->getMonthsUntilNewYear();

        foreach ($salaryPaymentDates as $date) {
            $dayCalculatorService = new DateCalculatorService($date);
            $data[] = [
                $dayCalculatorService->getFormattedMonth(),
                $dayCalculatorService->getSalaryPaymentDate(),
                $dayCalculatorService->getBonusPaymentDate(),
            ];
        }

        $this->fileWriterService->write($filePath, $data);
    }

    /**
     * @return array
     */
    private function getHeaders(): array
    {
        return [
            'Month',
            'Salary Payment Date',
            'Bonus Payment Date',
        ];
    }
}