<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use SSD\SalaryPayment\Services\DateCalculatorService;

/**
 * Class DateCalculatorServiceTest
 */
class DateCalculatorServiceTest extends TestCase
{
    /**
     * @var \Mockery\MockInterface
     */
    protected $dateTimeMock;

    /**
     * Basic setup for tests
     */
    public function setUp(): void
    {
        $this->dateTimeMock = \Mockery::mock(DateTime::class);
    }

    /**
     * Test salary payment day
     */
    public function testSalaryPaymentDate(): void
    {
        $dateTime = new \DateTime('28 February 2019');
        $this->dateTimeMock->shouldReceive('modify')
            ->once()
            ->with('last day of this month')
            ->andReturn($dateTime);

        $this->dateTimeMock->shouldReceive('modify')
            ->once()
            ->with('today')
            ->andReturn($dateTime);

        $dayCalculatorService = new DateCalculatorService($this->dateTimeMock);
        $result = $dayCalculatorService->getSalaryPaymentDate();
        $this->assertEquals('28-02-2019', $result);
    }

    /**
     * Test salary payment date when there is weekend
     */
    public function testSalaryPaymentDateIsWeekend(): void
    {
        $dateTime = new \DateTime('31 March 2019');
        $dateTimeMock = Mockery::mock(DateTime::class);
        $dateTimeMock->shouldReceive('modify')
            ->once()
            ->with('last day of this month')
            ->andReturn($dateTime);

        $dateTimeMock->shouldReceive('modify')
            ->once()
            ->with('today')
            ->andReturn($dateTime);

        $dayCalculatorService = new DateCalculatorService($dateTimeMock);
        $result = $dayCalculatorService->getSalaryPaymentDate();
        $this->assertEquals('29-03-2019', $result);
    }

    /**
     * Test if salary payment date passed and run the command
     */
    public function testSalaryPaymentDateIsPassed(): void
    {
        $dateTime = new \DateTime('31 March 2019');
        $today = new \DateTime('30 March 2019');
        $dateTimeMock = Mockery::mock(DateTime::class);
        $dateTimeMock->shouldReceive('modify')
            ->once()
            ->with('last day of this month')
            ->andReturn($dateTime);

        $dateTimeMock->shouldReceive('modify')
            ->once()
            ->with('today')
            ->andReturn($today);

        $dayCalculatorService = new DateCalculatorService($dateTimeMock);
        $result = $dayCalculatorService->getSalaryPaymentDate();
        $this->assertEquals('-', $result);
    }

    /**
     * Test bonus payment date
     */
    public function testBonusPaymentDate(): void
    {
        $dateTime = new \DateTime('28 February 2019');
        $bonusDateTime = new \DateTime('15 February 2019');

        $this->dateTimeMock->shouldReceive('modify->modify')
            ->twice()
            ->with('+14 days')
            ->andReturn($bonusDateTime);

        $this->dateTimeMock->shouldReceive('modify')
            ->once()
            ->with('today')
            ->andReturn($dateTime);

        $dayCalculatorService = new DateCalculatorService($this->dateTimeMock);
        $result = $dayCalculatorService->getBonusPaymentDate();
        $this->assertEquals('15-02-2019', $result);
    }

    /**
     * Test bonus payment date is weekend
     */
    public function testBonusPaymentDateIsWeekend(): void
    {
        $dateTime = new \DateTime('28 February 2019');
        $bonusDateTime = new \DateTime('16 February 2019');

        $this->dateTimeMock->shouldReceive('modify->modify')
            ->twice()
            ->with('+14 days')
            ->andReturn($bonusDateTime);

        $this->dateTimeMock->shouldReceive('modify')
            ->once()
            ->with('today')
            ->andReturn($dateTime);

        $dayCalculatorService = new DateCalculatorService($this->dateTimeMock);
        $result = $dayCalculatorService->getBonusPaymentDate();
        $this->assertEquals('20-02-2019', $result);
    }

    /**
     * Test bonus payment date is weekend
     */
    public function testBonusPaymentDateIsPassed(): void
    {

        $firstDay = new \DateTime('1 February 2019');
        $today = new \DateTime('18 February 2019');
        $bonusDay = new \DateTime('16 February 2019');
        $nextWednesday = new \DateTime('16 February 2019');

        $this->dateTimeMock->shouldReceive('modify')
            ->once()
            ->with('first day of this month')
            ->andReturn($firstDay);

        $this->dateTimeMock->shouldReceive('modify')
            ->once()
            ->with('+14 days')
            ->andReturn($bonusDay);

        $this->dateTimeMock->shouldReceive('modify')
            ->once()
            ->with('next wednesday')
            ->andReturn($nextWednesday);

        $this->dateTimeMock->shouldReceive('modify')
            ->once()
            ->with('today')
            ->andReturn($today);

        $dayCalculatorService = new DateCalculatorService($this->dateTimeMock);
        $result = $dayCalculatorService->getBonusPaymentDate();
        $this->assertEquals('-', $result);
    }

    /**
     * Test months until new year
     */
    public function testMonthsUntilNewYear(): void
    {
        $midNight = new \DateTime('01-02-2019 00:00:00');
        $this->dateTimeMock->shouldReceive('modify')
            ->once()
            ->with('midnight')
            ->andReturn($midNight);

        $dayCalculatorService = new DateCalculatorService($this->dateTimeMock);
        $result = $dayCalculatorService->getMonthsUntilNewYear();
        $this->assertCount(10, $result);
    }

    /**
     * Test to get formatted month
     */
    public function testGetFormattedMonth(): void
    {
        $month = 'February';
        $this->dateTimeMock->shouldReceive('format')
            ->once()
            ->with('F')
            ->andReturn($month);

        $dayCalculatorService = new DateCalculatorService($this->dateTimeMock);
        $result = $dayCalculatorService->getFormattedMonth();

        $this->assertEquals($month, $result);
    }
}
