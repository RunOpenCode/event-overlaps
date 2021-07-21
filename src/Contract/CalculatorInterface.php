<?php

declare(strict_types=1);

namespace RunOpenCode\EventOverlaps\Contract;

use RunOpenCode\EventOverlaps\Model\Violation;

interface CalculatorInterface extends \Countable
{
    /**
     * Add events to calculation.
     *
     * @psalm-suppress PossiblyUnusedMethod
     */
    public function append(EventInterface ...$events): void;

    /**
     * Remove event from calculation.
     *
     * @psalm-suppress PossiblyUnusedMethod
     */
    public function remove(EventInterface $event): void;

    /**
     * Remove all events from calculation.
     *
     * @psalm-suppress PossiblyUnusedMethod
     */
    public function clear(): void;

    /**
     * Is there overlapping between given events.
     *
     * @psalm-suppress PossiblyUnusedMethod
     */
    public function overlaps(): bool;

    /**
     * Get all overlapping violations.
     *
     * @psalm-suppress PossiblyUnusedMethod
     *
     * @return Violation[]
     */
    public function violations(): array;
}
