<?php
declare(strict_types=1);

namespace SSD\SalaryPayment\File;

/**
 * Class csv file writer
 */
class CsvWriter implements FileWriterInterface
{
    /**
     * Write the csv file
     *
     * @param string $path
     * @param array $data
     * @return void
     * @throws \Exception
     */
    public function write(string $path, array $data): void
    {
        if (empty($data)) {
            throw new \Exception('Insufficient data to write csv file.');
        }

        $csv = fopen($path, 'w');

        if (false === $csv) {
            throw new \Exception(sprintf('Unable to write to file: %s', $path));
        }

        foreach ($data as $item) {
            fputcsv($csv, $item);
        }

        fclose($csv);
    }
}
