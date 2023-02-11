<?php

declare(strict_types=1);

namespace Tests\Set;

use PHPUnit\Framework\TestCase;
use function AccumulatePHP\Series\mutableSeriesOf;
use function AccumulatePHP\Series\mutableSetOf;
use function AccumulatePHP\Series\seriesOf;

final class FunctionsTest extends TestCase
{
    /** @test */
    public function mutable_set_of_empty_series(): void
    {
        $mutableSeries = mutableSetOf();
        self::assertTrue($mutableSeries->isEmpty());
    }

    /** @test */
    public function mutable_set_of_with_elements(): void
    {
        $mutableSeries = mutableSetOf(1,2);
        self::assertTrue($mutableSeries->contains(1));
        self::assertTrue($mutableSeries->contains(2));
    }
}
