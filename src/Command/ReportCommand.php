<?php
declare(strict_types=1);

namespace SSD\SalaryPayment\Command;

use SSD\SalaryPayment\Services\ReportService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\{
    InputArgument,
    InputInterface
};
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class Report Command
 */
class ReportCommand extends Command
{
    /**
     * @var ReportService
     */
    protected $reportService;

    /**
     * PaymentCommand constructor.
     *
     * @param ReportService $reportService
     */
    public function __construct(ReportService $reportService)
    {
        $this->reportService = $reportService;
        parent::__construct();
    }

    /**
     * Setup payment day command with arguments
     */
    public function configure()
    {
        $this->setName('report:generate')
            ->setDescription('Generate a report with salary, bonus dates for sales staff for the remainder of the year')
            ->addArgument(
                'filename',
                InputArgument::REQUIRED,
                'Define the name of the outputted csv file'
            );
    }

    /**
     * Execute the command
     *
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int
     */
    public function execute(InputInterface $input, OutputInterface $output)
    {
        $filename = $input->getArgument('filename');

        try {
            $this->reportService->generate($filename);
        } catch (\Exception $exception) {
            $output->writeln('<error>' . $exception->getMessage() . '</error>');

            return 1;
        }

        $output->writeln('<info>Report has been successfully created.</info>');
        $output->writeln(
            '<info>All results are in <comment>' . ReportService::DIRECTORY_REPORT . DIRECTORY_SEPARATOR . $filename . '</comment> file.</info>'
        );

        return 0;
    }
}
