<?php
namespace Calendar\Adapter;

use Calendar\CalendarInterface;

/**
 * @author Florent Viel <florent.viel69@gmail.com>
 */
interface AdapterInterface
{
    /**
     * Adapte le tableau de périodes pour que la première période commence à partir de la date du jour
     *
     * @param  CalendarInterface $calendar tableau de périodes
     * @return CalendarInterface           tableau de périodes adapté
     */
    public function adapt(CalendarInterface $calendar);
}
