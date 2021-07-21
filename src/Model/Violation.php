<?php

declare(strict_types=1);

namespace RunOpenCode\EventOverlaps\Model;

use RunOpenCode\EventOverlaps\Contract\EventInterface;

final class Violation
{
    private EventInterface $first;

    private EventInterface $second;

    public function __construct(EventInterface $first, EventInterface $second)
    {
        $this->first  = $first;
        $this->second = $second;
    }

    /**
     * @psalm-suppress PossiblyUnusedMethod
     */
    public function getFirst(): EventInterface
    {
        return $this->first;
    }

    /**
     * @psalm-suppress PossiblyUnusedMethod
     */
    public function getSecond(): EventInterface
    {
        return $this->second;
    }
}
