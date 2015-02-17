<?php
namespace Calendar\Slicer;

use Calendar\CalendarInterface;

/**
 * @author Florent Viel <florent.viel69@gmail.com>
 */
interface SlicerInterface
{
    /**
     * Découpe le tableau de période de façon à pouvoir être utilisable par le driver
     *
     * @param  CalendarInterface $calendar tableau de périodes
     * @return CalendarInterface           tableau de périodes découpées
     */
    public function slice(CalendarInterface $calendar);
}
