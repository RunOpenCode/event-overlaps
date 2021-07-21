<?php

declare(strict_types=1);

namespace RunOpenCode\EventOverlaps;

use RunOpenCode\EventOverlaps\Contract\EventInterface;
use RunOpenCode\EventOverlaps\Enum\Unit;

/**
 * @throws \InvalidArgumentException
 */
function runopencode_event_overlaps(EventInterface $first, EventInterface $second, string $units, bool $allowStartAndEndIntersection): bool
{
    // units!!!!
    $firstStart  = $first->getStart() instanceof \DateTimeImmutable ? $first->getStart() : \DateTimeImmutable::createFromFormat(\DateTimeInterface::ATOM, $first->getStart()->format(\DateTimeInterface::ATOM));
    $firstEnd    = $first->getEnd() instanceof \DateTimeImmutable ? $first->getEnd() : \DateTimeImmutable::createFromFormat(\DateTimeInterface::ATOM, $first->getEnd()->format(\DateTimeInterface::ATOM));
    $secondStart = $second->getStart() instanceof \DateTimeImmutable ? $second->getStart() : \DateTimeImmutable::createFromFormat(\DateTimeInterface::ATOM, $second->getStart()->format(\DateTimeInterface::ATOM));
    $secondEnd   = $second->getEnd() instanceof \DateTimeImmutable ? $second->getEnd() : \DateTimeImmutable::createFromFormat(\DateTimeInterface::ATOM, $second->getEnd()->format(\DateTimeInterface::ATOM));

    \assert($firstStart instanceof \DateTimeImmutable);
    \assert($firstEnd instanceof \DateTimeImmutable);
    \assert($secondStart instanceof \DateTimeImmutable);
    \assert($secondEnd instanceof \DateTimeImmutable);

    if (Unit::SECOND !== $units) {
        $firstStart  = $firstStart->setTime((int)$firstStart->format('H'), Unit::HOUR === $units ? 0 : (int)$firstStart->format('i'));
        $firstEnd    = $firstEnd->setTime((int)$firstEnd->format('H'), Unit::HOUR === $units ? 0 : (int)$firstEnd->format('i'));
        $secondStart = $secondStart->setTime((int)$secondStart->format('H'), Unit::HOUR === $units ? 0 : (int)$secondStart->format('i'));
        $secondEnd   = $secondEnd->setTime((int)$secondEnd->format('H'), Unit::HOUR === $units ? 0 : (int)$secondEnd->format('i'));
    }

    $firstStartTimestamp  = $firstStart->getTimestamp();
    $firstEndTimestamp    = $firstEnd->getTimestamp();
    $secondStartTimestamp = $secondStart->getTimestamp();
    $secondEndTimestamp   = $secondEnd->getTimestamp();


    if ($firstStartTimestamp >= $firstEndTimestamp) {
        throw new \InvalidArgumentException(\sprintf('Provided event "%s" is not valid.', (string)$first->getReference()));
    }

    if ($secondStartTimestamp >= $secondEndTimestamp) {
        throw new \InvalidArgumentException(\sprintf('Provided event "%s" is not valid.', (string)$second->getReference()));
    }

    if ($allowStartAndEndIntersection && $firstEndTimestamp === $secondStartTimestamp) {
        return false;
    }

    if ($allowStartAndEndIntersection && $secondEndTimestamp === $firstStartTimestamp) {
        return false;
    }

    if ($firstStartTimestamp <= $secondStartTimestamp && $firstEndTimestamp >= $secondStartTimestamp) {
        return true;
    }

    if ($firstStartTimestamp <= $secondEndTimestamp && $firstEndTimestamp >= $secondEndTimestamp) {
        return true;
    }

    if ($firstStartTimestamp <= $secondStartTimestamp && $firstEndTimestamp >= $secondEndTimestamp) {
        return true;
    }

    if ($firstStartTimestamp >= $secondStartTimestamp && $firstEndTimestamp <= $secondEndTimestamp) {
        return true;
    }

    return false;
}
