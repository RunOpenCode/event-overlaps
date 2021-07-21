<?php

declare(strict_types=1);

namespace RunOpenCode\EventOverlaps\Tests\Adapter;

use PHPUnit\Framework\TestCase;
use RunOpenCode\EventOverlaps\Contract\AdapterInterface;
use RunOpenCode\EventOverlaps\Contract\EventInterface;
use RunOpenCode\EventOverlaps\Enum\Unit;
use RunOpenCode\EventOverlaps\Model\Event;

abstract class AbstractAdapterTest extends TestCase
{
    /**
     * @dataProvider dataProvider()
     *
     * @param EventInterface[] $events
     * @param array<array{string, string}> $expectedViolations
     */
    public function testAdapter(array $events, string $units, bool $allowStartAndEndIntersection, array $expectedViolations): void
    {
        $adapter = $this->getAdapter();

        $adapter->append(...$events);

        $violations = $adapter->violations($units, $allowStartAndEndIntersection);

        $this->assertCount(\count($expectedViolations), $violations);

        foreach ($violations as $index => $violation) {
            $this->assertContains($violation->getFirst()->getReference(), $expectedViolations[$index]);
            $this->assertContains($violation->getSecond()->getReference(), $expectedViolations[$index]);
        }
    }

    public function testRemove(): void
    {
        $adapter = $this->getAdapter();
        $event1  = new Event(new \DateTimeImmutable('2021-01-01T00:00:00'), new \DateTimeImmutable('2021-01-01T00:00:50'), '1');
        $event2  = new Event(new \DateTimeImmutable('2021-01-01T00:00:30'), new \DateTimeImmutable('2021-01-01T00:01:30'), '2');
        $event3  = new Event(new \DateTimeImmutable('2021-01-01T00:01:30'), new \DateTimeImmutable('2021-01-01T00:01:40'), '3');

        $adapter->append($event1, $event2, $event3);

        $this->assertCount(3, $adapter);

        $adapter->remove($event1);

        $this->assertCount(2, $adapter);

        $adapter->clear();

        $this->assertCount(0, $adapter);
    }

    public function dataProvider(): array
    {
        return [
            [
                [
                ],
                Unit::SECOND,
                true,
                [
                ],
            ],
            [
                [
                    new Event(new \DateTimeImmutable('2021-01-01T01:00:00'), new \DateTimeImmutable('2021-01-01T02:20:50'), '1'),
                    new Event(new \DateTimeImmutable('2021-01-01T01:55:30'), new \DateTimeImmutable('2021-01-01T03:01:30'), '2'),
                ],
                Unit::HOUR,
                true,
                [
                    ['1', '2'],
                ],
            ],
            [
                [
                    new Event(new \DateTimeImmutable('2021-01-01T00:00:00'), new \DateTimeImmutable('2021-01-01T00:00:50'), '1'),
                    new Event(new \DateTimeImmutable('2021-01-01T00:00:30'), new \DateTimeImmutable('2021-01-01T00:01:30'), '2'),
                    new Event(new \DateTimeImmutable('2021-01-01T00:01:30'), new \DateTimeImmutable('2021-01-01T00:01:40'), '3'),
                ],
                Unit::SECOND,
                true,
                [
                    ['1', '2'],
                ],
            ],
            [
                [
                    new Event(new \DateTimeImmutable('2021-01-01T00:00:00'), new \DateTimeImmutable('2021-01-01T00:01:50'), '1'),
                    new Event(new \DateTimeImmutable('2021-01-01T00:01:30'), new \DateTimeImmutable('2021-01-01T00:02:30'), '2'),
                    new Event(new \DateTimeImmutable('2021-01-01T00:02:30'), new \DateTimeImmutable('2021-01-01T00:05:40'), '3'),
                ],
                Unit::MINUTE,
                false,
                [
                    ['1', '2'],
                    ['2', '3'],
                ],
            ],
            [
                [
                    new Event(new \DateTimeImmutable('2021-01-01T00:00:00'), new \DateTimeImmutable('2021-01-01T00:01:50'), '1'),
                    new Event(new \DateTimeImmutable('2021-01-01T00:01:30'), new \DateTimeImmutable('2021-01-01T00:02:30'), '2'),
                    new Event(new \DateTimeImmutable('2021-01-01T00:02:30'), new \DateTimeImmutable('2021-01-01T00:05:40'), '3'),
                ],
                Unit::MINUTE,
                true,
                [
                ],
            ],
            [
                [
                    new Event(new \DateTimeImmutable('2021-01-01T00:00:20'), new \DateTimeImmutable('2021-01-01T00:00:30'), '1'),
                    new Event(new \DateTimeImmutable('2021-01-01T00:00:10'), new \DateTimeImmutable('2021-01-01T00:00:40'), '2'),
                    new Event(new \DateTimeImmutable('2021-01-01T00:00:25'), new \DateTimeImmutable('2021-01-01T00:00:27'), '3'),
                ],
                Unit::SECOND,
                true,
                [
                    ['1', '2'],
                    ['1', '3'],
                    ['2', '3'],
                ],
            ],
        ];
    }

    abstract protected function getAdapter(): AdapterInterface;
}
