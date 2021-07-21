<?php

declare(strict_types=1);

namespace RunOpenCode\EventOverlaps\Tests\Model;

use PHPUnit\Framework\TestCase;
use RunOpenCode\EventOverlaps\Model\Event;

final class EventTest extends TestCase
{
    public function testEventMustHaveValidDates(): void
    {
        $this->expectException(\InvalidArgumentException::class);

        new Event(new \DateTimeImmutable('2021-01-01T00:10:00'), new \DateTimeImmutable('2021-01-01T00:00:00'), '1');
    }

    public function testEventMustHaveValidReference(): void
    {
        $this->expectException(\InvalidArgumentException::class);

        new Event(new \DateTimeImmutable('2021-01-01T00:00:00'), new \DateTimeImmutable('2021-01-01T00:10:00'), '');
    }
}
