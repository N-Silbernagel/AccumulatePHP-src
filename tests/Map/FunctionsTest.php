<?php

declare(strict_types=1);

namespace Tests\Map;

use AccumulatePHP\Map\Entry;
use PHPUnit\Framework\TestCase;
use function AccumulatePHP\Series\mutableMapOf;
use function AccumulatePHP\Series\mutableSetOf;

final class FunctionsTest extends TestCase
{
    /** @test */
    public function mutable_map_of_empty_series(): void
    {
        $mutableSeries = mutableMapOf();
        self::assertTrue($mutableSeries->isEmpty());
    }

    /** @test */
    public function mutable_map_of_with_elements(): void
    {
        $mutableSeries = mutableMapOf(Entry::of(3, 1));
        self::assertSame(1, $mutableSeries->get(3));
    }
}
