<?php
declare(strict_types=1);

namespace SSD\SalaryPayment\Services;

/**
 * Class DateCalculatorService
 */
class DateCalculatorService
{
    /**
     * Week days
     */
    const WEEK_DAYS = 5;

    /**
     * Bonus days from start of month
     */
    const BONUS_DAYS = 15;

    /**
     * Date format
     */
    const FORMAT_DATE = 'd-m-Y';

    /**
     * Month format
     */
    const FORMAT_MONTH = 'F';

    /**
     * @var \DateTime
     */
    protected $date;

    /**
     * DateCalculatorService constructor.
     *
     * @param \DateTime $date
     */
    public function __construct(\DateTime $date)
    {
        $this->date = $date;
    }

    /**
     * Get date when salary should be paid and null if salary already paid
     *
     * @return string
     */
    public function getSalaryPaymentDate(): string
    {
        $lastDate = $this->date->modify('last day of this month');
        if ($this->isWeekend($lastDate)) {
            $lastDate = $lastDate->modify('previous friday');
        }

        $today = $this->date->modify('today');
        if ($today > $lastDate) {
            return '-';
        }

        return $lastDate->format(self::FORMAT_DATE);
    }

    /**
     * Get bonus payment date
     *
     * @return string
     */
    public function getBonusPaymentDate(): string
    {
        $bonusDate = $this->date->modify('first day of this month')
                                ->modify('+' . (self::BONUS_DAYS - 1) . ' days');

        if ($this->isWeekend($bonusDate)) {
            $bonusDate = $bonusDate->modify('next wednesday');
        }

        $today = $this->date->modify('today');
        if ($today > $bonusDate) {
            return '-';
        }

        return $bonusDate->format(self::FORMAT_DATE);
    }

    /**
     * Get the first day of every remaining month until new year
     *
     * @return array
     */
    public function getMonthsUntilNewYear(): array
    {
        $startDate = $this->date->modify('midnight');
        $endDate = new \DateTime('1st january next year');

        $month = new \DateInterval('P1M');
        $newPeriod = new \DateTime('first day of next month');
        $period = new \DatePeriod($newPeriod, $month, $endDate);
        $dates = [
            $startDate
        ];

        foreach ($period as $date) {
            $dates[] = $date;
        }

        return $dates;
    }

    /**
     * Get formatted month
     *
     * @return string
     */
    public function getFormattedMonth(): string
    {
        return $this->date->format(self::FORMAT_MONTH);
    }

    /**
     * Check if given date is weekend
     *
     * @param \DateTime $dateTime
     * @return bool
     */
    private function isWeekend(\DateTime $dateTime): bool
    {
        return $dateTime->format('N') > self::WEEK_DAYS;
    }
}
