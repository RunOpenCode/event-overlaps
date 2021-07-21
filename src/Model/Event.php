<?php

declare(strict_types=1);

namespace RunOpenCode\EventOverlaps\Model;

use RunOpenCode\EventOverlaps\Contract\EventInterface;

/**
 * @psalm-suppress UnusedClass
 */
final class Event implements EventInterface
{
    private \DateTimeInterface $start;

    private \DateTimeInterface $end;

    /**
     * @var mixed
     */
    private $reference;

    /**
     * @param mixed $reference
     *
     * @throws \InvalidArgumentException
     */
    public function __construct(\DateTimeInterface $start, \DateTimeInterface $end, $reference)
    {
        if ($start->getTimestamp() >= $end->getTimestamp()) {
            throw new \InvalidArgumentException('Start can not occur after the end of the event.');
        }

        if (empty($reference)) {
            throw new \InvalidArgumentException('You must provide identifier of the event, or event reference.');
        }

        $start = $start instanceof \DateTimeImmutable ? $start : \DateTimeImmutable::createFromFormat(\DateTimeInterface::ATOM, $start->format(\DateTimeInterface::ATOM));
        $end   = $end instanceof \DateTimeImmutable ? $end : \DateTimeImmutable::createFromFormat(\DateTimeInterface::ATOM, $end->format(\DateTimeInterface::ATOM));

        \assert($start instanceof \DateTimeImmutable);
        \assert($end instanceof \DateTimeImmutable);

        $this->start     = $start;
        $this->end       = $end;
        $this->reference = $reference;
    }

    public function getStart(): \DateTimeInterface
    {
        return $this->start;
    }

    public function getEnd(): \DateTimeInterface
    {
        return $this->end;
    }

    public function getReference()
    {
        return $this->reference;
    }
}
