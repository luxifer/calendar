<?php
namespace Calendar\Slicer;

use Calendar\CalendarInterface;
use Calendar\Calendar;
use Calendar\EquatablePeriodInterface;
use League\Period\Period as BasePeriod;
use DateInterval;
use UnexpectedValueException;

/**
 * Assemble les périodes juxtaposée de contenu identique
 *
 * @author Florent Viel <florent.viel69@gmail.com>
 */
class UniformPeriodSlicer implements SlicerInterface
{
    /**
     * @var \DateInterval
     */
    protected $maxPeriodLength;

    protected $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function slice(CalendarInterface $calendar)
    {
        $sliced = new Calendar();
        $current = $calendar->current();

        if (!$current instanceof EquatablePeriodInterface) {
            throw new UnexpectedValueException('Each period must implement Calender\\EquatablePeriodInterface.');
        }

        while ($period = $calendar->next()) {
            if (!$period instanceof EquatablePeriodInterface) {
                throw new UnexpectedValueException('Each period must implement Calender\\EquatablePeriodInterface.');
            }

            if ($current->equals($period)) {
                $current = $current->endingOn($period->getEnd());
            } else {
                $sliced->add($current);
                $current = $period;
            }
        }

        $sliced->add($current);

        if (isset($this->maxPeriodLength)) {
            $tmp = clone $sliced;
            $sliced->clear();

            foreach ($tmp as $period) {
                if ($period->getDuration()->d > $this->maxPeriodLength->d) {
                    $range = $period->getRange($this->maxPeriodLength);
                    $range = iterator_to_array($range);
                    $startDate = current($range);

                    while($date = next($range)) {
                        $endDate = $date;
                        $subPeriod = clone $period;
                        $subPeriod->setPeriod(new BasePeriod($startDate, $endDate));
                        $sliced->add($subPeriod);
                        $startDate = $endDate;
                    }

                    $lastPeriod = clone $period;
                    $lastPeriod->setPeriod(new BasePeriod($startDate, $period->getEnd()));
                    $sliced->add($lastPeriod);
                } else {
                    $sliced->add($period);
                }
            }
        }

        return $sliced;
    }

    public function setMaxPeriodLength($length)
    {
        $this->maxPeriodLength = new DateInterval(sprintf('P%dD', $length));
    }
}
