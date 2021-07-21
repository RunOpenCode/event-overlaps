<?php

declare(strict_types=1);

namespace RunOpenCode\EventOverlaps\Contract;

interface EventInterface
{
    /**
     * Get unique reference to event (can be anything, from identifier, to actual object).
     *
     * @return mixed
     */
    public function getReference();

    /**
     * Get start date/time of the event.
     */
    public function getStart(): \DateTimeInterface;

    /**
     * Get end date/time of the event.
     */
    public function getEnd(): \DateTimeInterface;
}
