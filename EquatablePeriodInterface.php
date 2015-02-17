<?php
namespace Calendar;

interface EquatablePeriodInterface extends PeriodInterface
{
    public function equals($period);
}
