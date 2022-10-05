<?php

declare(strict_types=1);

namespace AccumulatePHP\Set;

/**
 * @template TValue
 * @extends Set<TValue>
 */
interface MutableSet extends Set
{
    /**
     * @return bool true if the set did not already contain the element
     */
    public function add(mixed $element): bool;

    /**
     * @return bool true if the set included the element
     */
    public function remove(mixed $element): bool;
}
