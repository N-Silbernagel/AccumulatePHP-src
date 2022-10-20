<?php

declare(strict_types=1);

namespace Tests\Map;

use AccumulatePHP\Map\Entry;
use AccumulatePHP\Map\TreeMap;
use AccumulatePHP\Map\Map;
use PHPUnit\Framework\TestCase;
use Tests\AccumulationTestContract;

final class TreeMapTest extends TestCase implements MapTestContract, AccumulationTestContract
{
    /** @test */
    public function it_should_be_creatable_from_assoc_array(): void
    {
        $input = [
            'this' => 'is',
        ];

        $map = TreeMap::fromAssoc($input);

        self::assertSame('is', $map->get('this'));
    }

    /** @test */
    public function it_should_be_convertable_to_assoc_array(): void
    {
        // TODO: Implement it_should_be_convertable_to_assoc_array() method.
    }

    /** @test */
    public function it_should_ignore_non_scalar_keys_when_converting_to_assoc_array(): void
    {
        // TODO: Implement it_should_ignore_non_scalar_keys_when_converting_to_assoc_array() method.
    }

    /** @test */
    public function it_should_return_null_when_trying_to_remove_non_existent_key(): void
    {
        $map = TreeMap::new();

        $map->put('test', true);
        $result = $map->remove('nope');

        self::assertNull($result);
    }

    /** @test */
    public function it_should_allow_creating_empty_instance_via_static_factory(): void
    {
        $map = TreeMap::new();

        self::assertInstanceOf(TreeMap::class, $map);
        self::assertTrue($map->isEmpty());
    }

    /** @test */
    public function it_should_be_traversable(): void
    {
        $treeMap = TreeMap::fromAssoc([
            2 => true,
            1 => true,
            3 => true,
            4 => true,
        ]);

        $collected = [];

        foreach ($treeMap as $entry) {
            $collected[] = $entry;
        }

        $entryTwo = Entry::of(2, true);
        $entryOne = Entry::of(1, true);
        $entryThree = Entry::of(3, true);
        $entryFour = Entry::of(4, true);

        $expected = [
            $entryOne,
            $entryTwo,
            $entryThree,
            $entryFour
        ];
        self::assertEquals($expected, $collected);
    }

    /** @test */
    public function it_should_be_instantiatable_from_array(): void
    {
        $treeMapEntryOne = Entry::of('hi', 8);
        $treeMapEntryTwo = Entry::of('world', 16);

        $map = TreeMap::fromArray([$treeMapEntryOne, $treeMapEntryTwo]);

        self::assertSame(8, $map->get('hi'));
        self::assertSame(16, $map->get('world'));
    }

    /** @test */
    public function it_should_have_varargs_generator_method(): void
    {
        $treeMapEntryOne = Entry::of('hi', 8);
        $treeMapEntryTwo = Entry::of('world', 9);

        $map = TreeMap::of($treeMapEntryOne, $treeMapEntryTwo);

        self::assertSame(8, $map->get('hi'));
        self::assertSame(9, $map->get('world'));
    }

    /** @test */
    public function it_should_be_convertable_to_array(): void
    {
        $treeMap = TreeMap::new();

        $treeMap->put('test', 'me');
        $treeMap->put('real', 'good');

        $entryTwo = Entry::of('test', 'me');
        $entryOne = Entry::of('real', 'good');

        $expected = [
            $entryOne,
            $entryTwo,
        ];
        self::assertEquals($expected, $treeMap->toArray());
    }

    /** @test */
    public function it_should_allow_putting_entries_in()
    {
        /** @var Map<int, int> $treeMap */
        $treeMap = TreeMap::new();

        $treeMap->put(1, 2);

        self::assertSame(2, $treeMap->get(1));
    }

    /** @test */
    public function it_should_be_countable(): void
    {
        // TODO: Implement it_should_be_countable() method.
    }

    /** @test */
    public function it_should_allow_getting_values_as_series(): void
    {
        // TODO: Implement it_should_allow_getting_values_as_series() method.
    }
}
