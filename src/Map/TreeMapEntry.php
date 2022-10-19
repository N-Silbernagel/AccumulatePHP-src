<?php

declare(strict_types=1);

namespace AccumulatePHP\Map;

use JetBrains\PhpStorm\Pure;

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
     * @param TreeMapEntry<TKey, TValue>|null $left
     * @param TreeMapEntry<TKey, TValue>|null $right
     * @param TreeMapEntry<TKey, TValue>|null $parent
     */
    private function __construct(
        private readonly mixed $key,
        private mixed $value,
        private ?self $left = null,
        private ?self $right = null,
        private ?self $parent = null,
    )
    {
    }

    #[Pure]
    public static function of(
        mixed $key,
        mixed $value,
        ?self $left = null,
        ?self $right = null,
        ?self $parent = null
    ): self
    {
        return new self(
            $key,
            $value,
            $left,
            $right,
            $parent
        );
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
     * @return TreeMapEntry<TKey, TValue>|null
     */
    public function getParent(): ?TreeMapEntry
    {
        return $this->parent;
    }

    /**
     * @return TreeMapEntry<TKey, TValue>|null
     */
    public function getRight(): ?TreeMapEntry
    {
        return $this->right;
    }

    /**
     * @return TreeMapEntry<TKey, TValue>|null
     */
    public function getLeft(): ?TreeMapEntry
    {
        return $this->left;
    }

    public function setValue(mixed $value)
    {
        $this->value = $value;
    }

    public function setLeft(TreeMapEntry $entry)
    {
        $this->left = $entry;
    }

    public function setRight(TreeMapEntry $entry)
    {
        $this->right = $entry;
    }

    public function unsetLeft(): void
    {
        $this->left = null;
    }

    public function unsetRight()
    {
        $this->right = null;
    }
}
