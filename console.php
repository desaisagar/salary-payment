<?php

require_once __DIR__ . '/vendor/autoload.php';

date_default_timezone_set('Asia/Kolkata');

use Symfony\Component\Console\Application;
use SSD\SalaryPayment\Command\ReportCommand;
use \SSD\SalaryPayment\Services\{
    DateCalculatorService,
    ReportService
};
use SSD\SalaryPayment\File\CsvWriter;

define('PROJECT_ROOT', __DIR__);

$app = new Application();

$dayCalculatorService = new DateCalculatorService(new \DateTime());
$csvWriterService = new CsvWriter();
$reportService = new ReportService($dayCalculatorService, $csvWriterService);

$app->add(new ReportCommand($reportService));
$app->run();
