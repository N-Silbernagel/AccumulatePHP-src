<?php

declare(strict_types=1);

namespace AccumulatePHP\Map;

use AccumulatePHP\Accumulation;
use AccumulatePHP\Series\ArraySeries;
use AccumulatePHP\Series\Series;
use IteratorAggregate;
use JetBrains\PhpStorm\Pure;
use Traversable;

/**
 * @template TKey
 * @template TValue
 * @implements Map<TKey, TValue>
 * @implements IteratorAggregate<int, Entry<TKey, TValue>>
 */
final class TreeMap implements Map, IteratorAggregate
{
    private ?TreeMapEntry $root = null;
    private int $size = 0;

    private function __construct()
    {
    }

    /**
     * @return self<TKey, TValue>
     */
    public static function new(): self
    {
        return new self();
    }

    /**
     * @param Entry<TKey, TValue>[] $array
     * @return self<TKey, TValue>
     */
    public static function fromArray(array $array): self
    {
        $map = self::new();

        foreach ($array as $item) {
            $map->put($item->getKey(), $item->getValue());
        }

        return $map;
    }

    /**
     * @param Entry<TKey, TValue> ...$items
     * @return self<TKey, TValue>
     */
    public static function of(...$items): self
    {
        return self::fromArray($items);
    }

    public function toArray(): array
    {
        $entries = [];

        foreach ($this as $entry) {
            $entries[] = $entry;
        }

        return $entries;
    }

    /**
     * @return null|TValue
     */
    public function put(mixed $key, mixed $value): mixed
    {
        if (is_null($this->root)) {
            $this->root = TreeMapEntry::of($key, $value);
            $this->size++;
            return null;
        }

        $current = $this->root;

        do {
            $parent = $current;
            $comparisonResult = $this->compare($current->getKey(), $key);
            if ($comparisonResult === -1) {
                $current = $current->getLeft();
            } elseif ($comparisonResult === 1) {
                $current = $current->getRight();
            } else {
                $oldValue = $current->getValue();
                $current->setValue($value);
                return $oldValue;
            }
        } while ($current != null);

        $entry = TreeMapEntry::of($key, $value, parent: $parent);

        if ($comparisonResult === -1) {
            $parent->setLeft($entry);
        } else {
            $parent->setRight($entry);
        }

        $this->size++;
        return null;
    }

    public function remove(mixed $key): mixed
    {
        if (is_null($this->root)) {
            return null;
        }

        $current = $this->root;
        $fromLeft = false;

        do {
            $comparisonResult = $this->compare($current->getKey(), $key);

            if ($comparisonResult === 0) {
                if (is_null($current->getParent())) {
                    $newRootNode = $current->getLeft() ?? $current->getRight();
                    $this->root = $newRootNode;

                    $this->size--;
                    return $current->getValue();
                }

                if ($fromLeft) {
                    $current->getParent()->unsetLeft();
                } else {
                    $current->getParent()->unsetRight();
                }

                $this->size--;
                return $current->getValue();
            }

            if ($comparisonResult === -1) {
                $current = $current->getLeft();
                $fromLeft = true;
            } elseif ($comparisonResult === 1) {
                $current = $current->getRight();
                $fromLeft = false;
            }
        } while ($current != null);

        return null;
    }

    public function get(mixed $key): mixed
    {
        if (is_null($this->root)) {
            return null;
        }

        $current = $this->root;

        do {
            $comparisonResult = $this->compare($current->getKey(), $key);

            if ($comparisonResult === 0) {
                return $current->getValue();
            }

            if ($comparisonResult === -1) {
                $current = $current->getLeft();
            } elseif ($comparisonResult === 1) {
                $current = $current->getRight();
            }
        } while ($current != null);

        return null;
    }

    #[Pure]
    public function isEmpty(): bool
    {
        return $this->count() === 0;
    }

    public function count(): int
    {
        return $this->size;
    }

    public function values(): Series
    {
        $series = ArraySeries::new();

        foreach ($this as $entry) {
            $series->add($entry->getValue());
        }

        return $series;
    }

    public static function fromAssoc(array $assocArray): self
    {
        $new = TreeMap::new();

        foreach ($assocArray as $key => $item) {
            $new->put($key, $item);
        }

        return $new;
    }

    #[Pure]
    public function toAssoc(): array
    {
        $assoc = [];

        foreach ($this as $item) {
            if (is_scalar($item->getKey())) {
                $assoc[$item->getKey()] = $item->getValue();
            }
        }

        return $assoc;
    }

    public function getIterator(): Traversable
    {
        if (is_null($this->root)) {
            return;
        }

        $current = $this->getLeftMostNode($this->root);

        while (!is_null($current)) {
            yield $current->getEntry();

            $current = $this->getNextBiggerNode($current);
        }
    }

    #[Pure]
    private function getLeftMostNode(TreeMapEntry $root): TreeMapEntry
    {
        $current = $root;

        do {
            $previous = $current;
            $current = $current->getLeft();
        } while (!is_null($current));

        return $previous;
    }

    #[Pure]
    private function getNextBiggerNode(TreeMapEntry $current): ?TreeMapEntry
    {
        // if the node has a right node, that one is the next bigger
        $right = $current->getRight();

        if (!is_null($right)) {
            return $this->getLeftMostNode($right);
        }

        // otherwise we need to go up the tree
        $parent = $current->getParent();

        if (is_null($parent)) {
            return null;
        }

        // when we are "coming from the left" (eg. the current node is the left node of its parent)
        // the parent is the next bigger
        // find the next parent where we are "coming from the left"
        while ($parent?->getRight() === $current) {
            $current = $parent;
            $parent = $parent->getParent();
        }

        // if there ist no such parent, we've had the biggest element of the tree, which is the rightmost
        if (is_null($parent)) {
            return null;
        }

        // if we found a parent were we "came from the left", that is the next bigger node
        return $parent;
    }

    private function compare(mixed $target, mixed $comparison): int
    {
        if (is_scalar($target) !== is_scalar($comparison)) {
            throw new IncomparableKeysException($target, $comparison);
        }
        return $comparison <=> $target;
    }
}
