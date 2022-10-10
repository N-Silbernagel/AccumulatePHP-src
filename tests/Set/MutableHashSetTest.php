<?php

declare(strict_types=1);

namespace Tests\Set;

use AccumulatePHP\Set\MutableHashSet;
use AccumulatePHP\Set\MutableSet;
use PHPUnit\Framework\TestCase;
use Tests\Map\UnequalHashable;

final class MutableHashSetTest extends TestCase
{
    /** @test */
    public function it_should_be_traversable(): void
    {
        /** @var MutableSet<UnequalHashable> $set */
        $set = MutableHashSet::new();

        $one = new UnequalHashable(5, 1);
        $two = new UnequalHashable(5, 2);
        $three = new UnequalHashable(10, 1);

        $set->add($one);
        $set->add($two);
        $set->add($three);

        $actual = [];
        foreach ($set as $item) {
            $actual[] = $item;
        }

        $expected = [$one, $two, $three];
        self::assertEqualsCanonicalizing($expected, $actual);
    }

}
