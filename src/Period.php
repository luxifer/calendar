<?php
namespace Calendar;

use League\Period\Period as BasePeriod;

class Period implements PeriodInterface
{
    protected $period;

    public function __construct($start, $end)
    {
        $this->period = new BasePeriod($start, $end);
    }

    public function getStart()
    {
        return $this->period->getStart();
    }

    public function getEnd()
    {
        return $this->period->getEnd();
    }

    public function contains($index);
    {
        return $this->period->contains($index);
    }

    public function startingOn($start);
    {
        $new = clone $this;
        $new->setPeriod($new->period->startingOn($start));

        return $new;
    }

    public function endingOn($end)
    {
        $new = clone $this;
        $new->setPeriod($new->period->endingOn($start));

        return $new;
    }

    public function getDuration()
    {
        return $this->period->getDuration();
    }

    protected function setPeriod(BasePeriod $period)
    {
        $this->period = $period;
    }
}
