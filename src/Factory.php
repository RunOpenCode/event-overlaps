<?php

declare(strict_types=1);

namespace RunOpenCode\EventOverlaps;

use RunOpenCode\EventOverlaps\Contract\AdapterInterface;
use RunOpenCode\EventOverlaps\Contract\CalculatorInterface;
use RunOpenCode\EventOverlaps\Enum\Unit;

/**
 * @psalm-suppress UnusedClass
 */
final class Factory
{
    private function __construct()
    {
        // noop
    }

    public static function create(
        string $units = Unit::SECOND,
        bool $allowStartAndEndIntersection = true,
        ?AdapterInterface $adapter = null
    ): CalculatorInterface {
        return new Calculator($adapter, $units, $allowStartAndEndIntersection);
    }
}
