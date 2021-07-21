<?php

declare(strict_types=1);

namespace RunOpenCode\EventOverlaps\Tests;

use PHPUnit\Framework\TestCase;
use RunOpenCode\EventOverlaps\Calculator;
use RunOpenCode\EventOverlaps\Model\Event;

final class CalculatorTest extends TestCase
{
    public function testEventsCollection(): void
    {
        $calculator = new Calculator();

        $event1 = new Event(new \DateTimeImmutable('2021-01-01T00:00:00'), new \DateTimeImmutable('2021-01-01T00:00:50'), '1');
        $event2 = new Event(new \DateTimeImmutable('2021-01-01T00:00:30'), new \DateTimeImmutable('2021-01-01T00:01:30'), '2');
        $event3 = new Event(new \DateTimeImmutable('2021-01-01T00:01:30'), new \DateTimeImmutable('2021-01-01T00:01:40'), '3');


        $calculator->append($event1, $event2, $event3);

        $this->assertCount(3, $calculator);

        $calculator->remove($event1);

        $this->assertCount(2, $calculator);

        $calculator->clear();

        $this->assertCount(0, $calculator);
    }

    public function testCalculation(): void
    {
        $calculator = new Calculator();

        $event1 = new Event(new \DateTimeImmutable('2021-01-01T00:00:00'), new \DateTimeImmutable('2021-01-01T00:00:30'), '1');
        $event2 = new Event(new \DateTimeImmutable('2021-01-01T00:00:30'), new \DateTimeImmutable('2021-01-01T00:01:30'), '2');
        $event3 = new Event(new \DateTimeImmutable('2021-01-01T00:01:00'), new \DateTimeImmutable('2021-01-01T00:01:40'), '3');

        $calculator->append($event1, $event2);

        $this->assertFalse($calculator->overlaps());

        $calculator->append($event3);

        $violations = $calculator->violations();

        $this->assertTrue($calculator->overlaps());

        $this->assertCount(1, $violations);
        $this->assertContains($violations[0]->getFirst()->getReference(), ['2', '3']);
        $this->assertContains($violations[0]->getSecond()->getReference(), ['2', '3']);
    }
}
