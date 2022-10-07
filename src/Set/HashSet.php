<?php

declare(strict_types=1);

namespace AccumulatePHP\Set;

use AccumulatePHP\Accumulation;
use AccumulatePHP\Map\HashMap;
use AccumulatePHP\Map\UnsupportedHashMapKeyException;
use IteratorAggregate;
use Traversable;

/**
 * @template T
 * @implements MutableSet<T>
 * @implements IteratorAggregate<int, T>
 */
final class HashSet implements MutableSet, IteratorAggregate
{
    /** @param HashMap<T, true> $hashMap */
    private function __construct(
        /** @var HashMap<T, true> */
        private readonly HashMap $hashMap
    )
    {
    }

    /**
     * @return self<T>
     */
    public static function new(): self
    {
        /** @var HashMap<T, true> $hashMap */
        $hashMap = HashMap::new();
        return new self($hashMap);
    }

    public function isEmpty(): bool
    {
        return $this->hashMap->isEmpty();
    }

    public function count(): int
    {
        return $this->hashMap->count();
    }

    /**
     * @throws UnsupportedHashMapKeyException
     */
    public function add(mixed $element): bool
    {
        $putResult = $this->hashMap->put($element, true);

        return $putResult === null;
    }

    public function remove(mixed $element): bool
    {
        return $this->hashMap->remove($element) !== null;
    }

    public function getIterator(): Traversable
    {
        // TODO: Implement getIterator() method.
    }
}
