<?php

declare(strict_types=1);

namespace AccumulatePHP\Set;

use AccumulatePHP\Accumulation;
use AccumulatePHP\Map\HashMap;
use AccumulatePHP\Map\UnsupportedHashMapKeyException;

/**
 * @template TValue
 * @extends MutableSet<TValue>
 */
final class HashSet implements MutableSet
{
    private int $key = 0;

    public function __construct(
        /** @param HashMap<TValue, true> */
        private readonly HashMap $hashMap
    )
    {
    }

    public static function new(): Accumulation
    {
        return new self(HashMap::new());
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
}
