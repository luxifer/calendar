<?php
namespace Calendar;

use Calendar\PeriodInterface;
use Doctrine\Common\Collections\ArrayCollection;
use UnexpectedValueException;

/**
 * @author Florent Viel <florent.viel69@gmail.com>
 */
class Calendar extends ArrayCollection implements CalendarInterface
{
    public function add($period)
    {
        if (!$period instanceof PeriodInterface) {
            throw new UnexpectedValueException('Each period must implement Calender\\PeriodInterface.');
        }

        parent::add($period);

        return true;
    }
}
