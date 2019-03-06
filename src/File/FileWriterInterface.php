<?php

namespace SSD\SalaryPayment\File;

/**
 * Interface for classes which write file
 */
interface FileWriterInterface
{
    /**
     * Write the file
     *
     * @param string $path
     * @param array $data
     * @return void
     */
    public function write(string $path, array $data): void;
}
