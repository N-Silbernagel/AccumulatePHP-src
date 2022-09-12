<?php

declare(strict_types=1);

namespace AccumulatePHP\Map;

use AccumulatePHP\Accumulation;

/**
 * @template TKey
 * @template TValue
 */
interface Map
{
    /**
     * @param TKey $key
     * @return TValue
     */
    public function get(mixed $key);

    public function isEmpty(): bool;

    public function count(): int;

    /**
     * @return Accumulation<TValue>
     */
    public function values(): Accumulation;
}
