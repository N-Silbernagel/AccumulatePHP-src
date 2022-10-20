<?php

declare(strict_types=1);

namespace AccumulatePHP\Map;

use JetBrains\PhpStorm\Pure;

/**
 * @template TKey
 * @template TValue
 */
final class TreeMapEntry
{
    /**
     * @param Entry<TKey, TValue> $entry
     * @param TreeMapEntry<TKey, TValue>|null $parent
     * @param TreeMapEntry<TKey, TValue>|null $left
     * @param TreeMapEntry<TKey, TValue>|null $right
     */
    private function __construct(
        private readonly Entry $entry,
        private readonly ?self $parent = null,
        private ?self          $left = null,
        private ?self          $right = null,
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
            Entry::of($key, $value),
            $parent,
            $left,
            $right
        );
    }

    /**
     * @return TKey
     */
    #[Pure]
    public function getKey(): mixed
    {
        return $this->entry->getKey();
    }

    /**
     * @return TValue
     */
    #[Pure]
    public function getValue(): mixed
    {
        return $this->entry->getValue();
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

    /**
     * @return Entry<TKey, TValue>
     */
    public function getEntry(): Entry
    {
        return $this->entry;
    }

    public function setValue(mixed $value): void
    {
        $this->value = $value;
    }

    public function setLeft(TreeMapEntry $entry): void
    {
        $this->left = $entry;
    }

    public function setRight(TreeMapEntry $entry): void
    {
        $this->right = $entry;
    }

    public function unsetLeft(): void
    {
        $this->left = null;
    }

    public function unsetRight(): void
    {
        $this->right = null;
    }
}
