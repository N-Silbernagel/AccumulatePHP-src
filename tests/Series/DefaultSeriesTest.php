<?php

declare(strict_types=1);

namespace Tests\Series;

use AccumulatePHP\Series\DefaultSeries;
use AccumulatePHP\Series\Series;
use PHPUnit\Framework\TestCase;
use Tests\AccumulationTestContract;

final class DefaultSeriesTest extends TestCase implements AccumulationTestContract, SeriesTestContract
{
    /** @test */
    public function it_should_allow_creating_empty_instance_via_static_factory(): void
    {
        $series = DefaultSeries::new();

        self::assertTrue($series->isEmpty());
    }

    /** @test */
    public function it_should_allow_getting_items_by_index(): void
    {
        /** @var string[] $data */
        $data = [
            'test5',
            'test2',
            'test'
        ];

        $series = DefaultSeries::fromArray($data);

        $getValue = $series->get(2);

        self::assertSame('test', $getValue);
    }

    /** @test */
    public function it_should_be_creatable_from_array(): void
    {
        /** @var array<int> $intArray */
        $intArray = [1, 10, 5];

        $fromArray = DefaultSeries::fromArray($intArray);

        self::assertSame(3, $fromArray->count());
    }

    /** @test */
    public function it_should_keep_order_of_passed_array(): void
    {
        /** @var array<int> $intArray */
        $intArray = [1, 44542, 2];

        $fromArray = DefaultSeries::fromArray($intArray);

        self::assertSame(44542, $fromArray->get(1));
        self::assertSame(1, $fromArray->get(0));
        self::assertSame(2, $fromArray->get(2));
    }

    /** @test */
    public function it_should_allow_mapping_according_to_a_closure(): void
    {
        /**
         * @var Series<int> $series
         */
        $series = DefaultSeries::fromArray([1, 2, 3]);

        $mappedSeries = $series->map(function (int $item) {
            return $item * 2;
        });

        self::assertSame(1, $series->get(0));
        self::assertSame(2, $series->get(1));
        self::assertSame(3, $series->get(2));

        self::assertSame(2, $mappedSeries->get(0));
        self::assertSame(4, $mappedSeries->get(1));
        self::assertSame(6, $mappedSeries->get(2));
    }

    /** @test */
    public function it_can_be_converted_to_array(): void
    {
        $inputArray = ['xy', 'z'];

        $series = DefaultSeries::fromArray($inputArray);

        self::assertEquals($inputArray, $series->toArray());
    }

    /** @test */
    public function it_has_varargs_generator_method(): void
    {
        $mutableSeries = DefaultSeries::of('x', 'y', 'z');

        self::assertEquals([
            'x',
            'y',
            'z'
        ], $mutableSeries->toArray());
    }

    /** @test */
    public function it_is_filterable_through_callable(): void
    {
        /** @var Series<string> $series */
        $series = DefaultSeries::of('1', '12.4', 'abc');

        $filteredSeries = $series->filter(fn(string $item) => is_numeric($item));

        self::assertEquals([
            '1',
            '12.4'
        ], $filteredSeries->toArray());
    }

    /** @test */
    public function it_should_be_traversable(): void
    {
        $traversedItems = [];

        /** @var array<int|string> $inputArray */
        $inputArray = ['123', 5, -13];

        $accumulation = DefaultSeries::fromArray($inputArray);
        foreach ($accumulation as $item) {
            $traversedItems[] = $item;
        }

        self::assertEquals($inputArray, $traversedItems);
    }

    /** @test */
    public function it_can_be_made_from_assoc_array(): void
    {
        $input = [
            0 => 0,
            'test' => 10
        ];

        /** @var Series<int> $series */
        $series = DefaultSeries::fromArray($input);

        self::assertSame(0, $series->get(0));
        self::assertSame(10, $series->get(1));
    }

    /** @test */
    public function it_should_know_if_it_contains_element(): void
    {
        /** @var Series<int> $series */
        $series = DefaultSeries::of(1, 2, 3);

        self::assertTrue($series->containsLoose(1));
        self::assertFalse($series->containsLoose(4));
    }

    /** @test */
    public function contains_loose_should_be_non_strict(): void
    {
        /** @var Series<int|string> $series */
        $series = DefaultSeries::of(1, 2, 3);

        self::assertTrue($series->containsLoose(2));
        self::assertTrue($series->containsLoose('2'));
    }

    /** @test */
    public function it_should_know_if_it_strictly_contains_element(): void
    {
        /** @var Series<int> $series */
        $series = DefaultSeries::of(9, 55, 2);

        self::assertTrue($series->contains(55));
        self::assertFalse($series->contains(100));
    }

    /** @test */
    public function contains_should_be_strict(): void
    {
        /** @var Series<int|string> $series */
        $series = DefaultSeries::of(1, 2, 3);

        self::assertTrue($series->contains(2));
        self::assertFalse($series->contains('2'));
    }

    /** @test */
    public function find_should_return_match_if_exists(): void
    {
        /** @var Series<string> $series */
        $series = DefaultSeries::of('hello', 'world');

        $actual = $series->find(fn(string $element) => str_starts_with($element, 'w'));
        self::assertSame('world', $actual);
    }

    /** @test */
    public function find_should_return_null_if_no_match_exists(): void
    {
        /** @var Series<string> $series */
        $series = DefaultSeries::of('hello', 'world');

        $actual = $series->find(fn(string $element) => str_starts_with($element, 'not'));
        self::assertNull($actual);
    }
}
