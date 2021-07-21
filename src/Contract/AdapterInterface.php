<?php

declare(strict_types=1);

namespace RunOpenCode\EventOverlaps\Contract;

use RunOpenCode\EventOverlaps\Enum\Unit;
use RunOpenCode\EventOverlaps\Model\Violation;

interface AdapterInterface extends \Countable
{
    /**
     * Add events to collection.
     */
    public function append(EventInterface ...$events): void;

    /**
     * Remove event from collection.
     */
    public function remove(EventInterface $event): void;

    /**
     * Remove all events from collection.
     */
    public function clear(): void;

    /**
     * Get all overlapping events violations.
     *
     * @return Violation[]
     */
    public function violations(string $units = Unit::SECOND, bool $allowStartAndEndIntersection = true): array;
}
