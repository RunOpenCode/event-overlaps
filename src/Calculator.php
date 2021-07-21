<?php

declare(strict_types=1);

namespace RunOpenCode\EventOverlaps;

use RunOpenCode\EventOverlaps\Adapter\Matrix;
use RunOpenCode\EventOverlaps\Contract\AdapterInterface;
use RunOpenCode\EventOverlaps\Contract\CalculatorInterface;
use RunOpenCode\EventOverlaps\Contract\EventInterface;
use RunOpenCode\EventOverlaps\Enum\Unit;
use RunOpenCode\EventOverlaps\Model\Violation;

final class Calculator implements CalculatorInterface
{
    private AdapterInterface $adapter;

    private string $units;

    private bool $allowStartAndEndIntersection;

    /**
     * @var Violation[]
     */
    private ?array $lastViolations = null;

    public function __construct(?AdapterInterface $adapter = null, string $units = Unit::SECOND, bool $allowStartAndEndIntersection = true)
    {
        $this->adapter                      = $adapter ?? new Matrix();
        $this->units                        = $units;
        $this->allowStartAndEndIntersection = $allowStartAndEndIntersection;
    }

    public function append(EventInterface ...$events): void
    {
        $this->adapter->append(...$events);
        $this->lastViolations = null;
    }

    public function remove(EventInterface $event): void
    {
        $this->adapter->remove($event);
        $this->lastViolations = null;
    }

    public function clear(): void
    {
        $this->adapter->clear();
        $this->lastViolations = null;
    }

    public function overlaps(): bool
    {
        if (null === $this->lastViolations) {
            $this->lastViolations = $this->adapter->violations($this->units, $this->allowStartAndEndIntersection);
        }

        return 0 !== \count($this->lastViolations);
    }

    public function violations(): array
    {
        if (null === $this->lastViolations) {
            $this->lastViolations = $this->adapter->violations($this->units, $this->allowStartAndEndIntersection);
        }

        return $this->lastViolations;
    }

    /**
     * @psalm-suppress PossiblyUnusedMethod
     */
    public function count(): int
    {
        return \count($this->adapter);
    }
}
