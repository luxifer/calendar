<?php
namespace Calendar;

use League\Period\Period as BasePeriod;
use UnexpectedValueException;

/**
 * @author Florent Viel <florent.viel69@gmail.com>
 */
class Period implements EquatablePeriodInterface
{
    public $content;

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

    public function getRange($interval)
    {
        return $this->period->getRange($interval);
    }

    public function setPeriod(BasePeriod $period)
    {
        $this->period = $period;
    }

    public function equals($period)
    {
        if (!$period instanceof Period) {
            throw new UnexpectedValueException('Compared period must have the same class.');
        }

        return $this->content === $period->content;
    }
}
