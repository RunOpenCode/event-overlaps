<?php

declare(strict_types=1);

namespace RunOpenCode\EventOverlaps\Adapter;

use RunOpenCode\EventOverlaps\Contract\AdapterInterface;
use RunOpenCode\EventOverlaps\Contract\EventInterface;
use RunOpenCode\EventOverlaps\Enum\Unit;
use RunOpenCode\EventOverlaps\Model\Violation;
use function RunOpenCode\EventOverlaps\runopencode_event_overlaps;

final class Matrix implements AdapterInterface
{
    /**
     * @var EventInterface[]
     */
    private array $events = [];

    public function append(EventInterface ...$events): void
    {
        foreach ($events as $event) {
            $this->events[] = $event;
        }
    }

    public function remove(EventInterface $event): void
    {
        $this->events = \array_filter($this->events, static function (EventInterface $current) use ($event): bool {
            return $event !== $current;
        });
    }

    public function clear(): void
    {
        $this->events = [];
    }

    /**
     * @throws \InvalidArgumentException
     *
     * @return Violation[]
     */
    public function violations(string $units = Unit::SECOND, bool $allowStartAndEndIntersection = true): array
    {
        $count = \count($this->events);

        if (1 >= $count) {
            return [];
        }

        if (2 === $count) {
            if (runopencode_event_overlaps($this->events[0], $this->events[1], $units, $allowStartAndEndIntersection)) {
                return [new Violation($this->events[0], $this->events[1])];
            }

            return [];
        }

        $violations = [];

        for ($i = 1; $i < $count; $i++) {
            for ($j = 0; $j < $i; $j++) {
                if (runopencode_event_overlaps($this->events[$i], $this->events[$j], $units, $allowStartAndEndIntersection)) {
                    $violations[] = new Violation($this->events[$i], $this->events[$j]);
                }
            }
        }

        return $violations;
    }

    /**
     * @psalm-suppress PossiblyUnusedMethod
     */
    public function count(): int
    {
        return \count($this->events);
    }
}
