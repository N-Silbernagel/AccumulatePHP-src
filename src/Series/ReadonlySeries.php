<?php

declare(strict_types=1);

namespace AccumulatePHP\Series;

use AccumulatePHP\SequencedAccumulation;

/**
 * @template T
 * @extends SequencedAccumulation<int,T>
 */
interface ReadonlySeries extends SequencedAccumulation
{
    /**
     * @template CallableReturnType
     * @param callable(T): CallableReturnType $mapConsumer
     * @return ReadonlySeries<CallableReturnType>
     */
    public function map(callable $mapConsumer): ReadonlySeries;

    /**
     * @return T
     */
    public function get(int $index): mixed;

    /**
     * @param callable(T): bool $filterConsumer
     * @return ReadonlySeries<T>
     */
    public function filter(callable $filterConsumer): ReadonlySeries;

    /** @param T $element */
    public function containsLoose(mixed $element): bool;

    /** @param T $element */
    public function contains(mixed $element): bool;

    /**
     * @param callable(T): bool $findConsumer
     * @return T|null first element that matched the consumer or null
     */
    public function find(callable $findConsumer): mixed;

    /**
     * @param callable(T): bool $findConsumer
     * @return int|null index of first matched element or null
     */
    public function findIndex(callable $findConsumer): ?int;
}
