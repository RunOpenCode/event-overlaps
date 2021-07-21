<?php

declare(strict_types=1);

namespace RunOpenCode\EventOverlaps\Tests\Adapter;

use RunOpenCode\EventOverlaps\Adapter\Matrix;
use RunOpenCode\EventOverlaps\Contract\AdapterInterface;

final class MatrixTest extends AbstractAdapterTest
{
    protected function getAdapter(): AdapterInterface
    {
        return new Matrix();
    }
}
