<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Application;
use SSD\SalaryPayment\Command\ReportCommand;
use Symfony\Component\Console\Tester\CommandTester;
use SSD\SalaryPayment\Services\ReportService;
/**
 * Class PaymentCommandTest
 */
class ReportCommandTest extends TestCase
{
    /**
     * @var Mockery\MockInterface
     */
    protected $reportServiceMock;

    /**
     * Basic setup for the tests
     */
    public function setUp(): void
    {
        $this->reportServiceMock = Mockery::mock(ReportService::class);
    }

    /**
     * Test for the configure
     */
    public function testConfigure(): void
    {
        $this->markTestIncomplete();
    }

    /**
     * Test execute
     */
    public function testExecute(): void
    {
        $this->markTestIncomplete();

        $application = new Application();
        $application->add(new ReportCommand());

        $command = $application->find('report:generate');

        $commandTester = new CommandTester($command);
        $filename = 'testcsv.csv';

        $commandTester->execute([
            'command' => $command->getName(),
            'filename' => $filename
        ]);

        $this->assertStringContainsString('Report has been successfully created', $commandTester->getDisplay());

    }
}