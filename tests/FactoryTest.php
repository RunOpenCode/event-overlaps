<?php

declare(strict_types=1);

namespace RunOpenCode\EventOverlaps\Tests;

use PHPUnit\Framework\TestCase;
use RunOpenCode\EventOverlaps\Contract\CalculatorInterface;
use RunOpenCode\EventOverlaps\Factory;

final class FactoryTest extends TestCase
{
    public function testGetCalculator(): void
    {
        $this->assertInstanceOf(CalculatorInterface::class, Factory::create());
    }
}
