<?php

declare(strict_types=1);

namespace RunOpenCode\EventOverlaps\Enum;

final class Unit
{
    public const SECOND = 'second';

    public const MINUTE = 'minute';

    public const HOUR = 'hour';

    /**
     * @psalm-suppress UnusedConstructor
     */
    private function __construct()
    {
        // noop
    }
}
