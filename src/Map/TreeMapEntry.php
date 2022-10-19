<?php

declare(strict_types=1);

namespace AccumulatePHP\Map;

/**
 * @template TKey
 * @template TValue
 * @implements Entry<TKey, TValue>
 */
final class TreeMapEntry implements Entry
{
    /**
     * @param TKey $key
     * @param TValue $value
     * @param TreeMapEntry<TKey, TValue> $left
     * @param TreeMapEntry<TKey, TValue> $right
     * @param TreeMapEntry<TKey, TValue> $parent
     */
    private function __construct(
        private readonly mixed $key,
        private readonly mixed $value,
        private readonly self $left,
        private readonly self $right,
        private readonly self $parent,
    )
    {
    }

    public function getKey(): mixed
    {
        return $this->key;
    }

    public function getValue(): mixed
    {
        return $this->value;
    }

    /**
     * @return TreeMapEntry<TKey, TValue>
     */
    public function getParent(): TreeMapEntry
    {
        return $this->parent;
    }

    /**
     * @return TreeMapEntry<TKey, TValue>
     */
    public function getRight(): TreeMapEntry
    {
        return $this->right;
    }

    /**
     * @return TreeMapEntry<TKey, TValue>
     */
    public function getLeft(): TreeMapEntry
    {
        return $this->left;
    }
}
