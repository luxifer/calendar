<?php
namespace Calendar;

interface PeriodInterface
{
    /**
     * Get period start date
     * @return \DateTime
     */
    public function getStart();

    /**
     * Get period end date
     * @return \DateTime
     */
    public function getEnd();

    /**
     * Test if the index is fully contained in the period
     */
    public function contains($index);

    /**
     * Sets the new start date
     * @return PeriodInterface
     */
    public function startingOn($start);

    /**
     * Sets the new end date
     * @return PeriodInterface
     */
    public function endingOn($end);

    /**
     * Returns the duration of the period
     * @return \DateInterval
     */
    public function getDuration();
}
