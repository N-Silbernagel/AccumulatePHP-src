<?php

declare(strict_types=1);

namespace AccumulatePHP\Series;

use AccumulatePHP\Map\Entry;
use AccumulatePHP\Map\HashMap;
use AccumulatePHP\Map\MutableMap;

if (!function_exists('AccumulatePHP\Series\mutableMapOf')) {
    /**
     * @template TKey
     * @template TValue
     * @param Entry<TKey, TValue> ...$items
     * @return MutableMap<Entry<TKey, TValue>>
     */
    function mutableMapOf(...$items): MutableMap
    {
        return HashMap::fromArray($items);
    }
}
