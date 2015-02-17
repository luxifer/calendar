<?php
namespace Calendar\Adapter;

use Calendar\CalendarInterface;
use Calendar\Calendar;
use Calendar\PeriodInterface;
use DateTime, DateTimeZone, DateInterval;
use UnexpectedValueException;

/**
 * @author Florent Viel <florent.viel69@gmail.com>
 */
class StandardAdapter implements AdapterInterface
{
    /**
     * @var \DateTime
     */
    protected $maxDateSync;

    /**
     * {@inheritdoc}
     *
     * Le tableau de périodes se termine à self::$maxDateSync si cet attribut est défini
     */
    public function adapt(CalendarInterface $calendar);
    {
        $now = $this->getNow();
        $adapted = new Calendar();

        foreach ($periods as $period) {
            if (!$period instanceof PeriodInterface) {
                throw new UnexpectedValueException('Each period must implement Calender\\PeriodInterface.');
            }

            if ($period->getEnd() < $now) {
                continue;
            }

            if ($period->contains($now)) {
                $period = $period->startingOn($now);
            }

            if (isset($this->maxDateSync)) {
                if ($period->getStart() > $this->maxDateSync) {
                    break;
                }

                if ($period->contains($this->maxDateSync)) {
                    $period = $period->endingOn($this->maxDateSync);
                }
            }

            if ($period->getDuration()->days > 0) {
                $adapted->add($period);
            }
        }

        return $adapted;
    }

    public function getNow()
    {
        $now = new DateTime('now', new DateTimeZone('UTC'));
        $now->setTime(18, 0, 0);

        return $now;
    }

    public function setMaxDateSync($maxDateSync)
    {
        $maxDate = clone $this->getNow();
        $maxDate->add(new DateInterval(sprintf('P%dD', $maxDateSync + 1)));

        $this->maxDateSync = $maxDate;
    }

    public function getMaxDateSync()
    {
        return $this->maxDateSync;
    }
}
