<?php

declare(strict_types=1);

namespace AccumulatePHP\Set;

use AccumulatePHP\Series\MutableArraySeries;
use AccumulatePHP\Series\MutableSeries;
use IteratorAggregate;
use Traversable;

/**
 * @template T
 * @implements MutableSet<T>
 * @implements IteratorAggregate<int, T>
 */
final class MutableStrictSet implements MutableSet, IteratorAggregate
{
    private MutableSeries $repository;

    /** @param MutableSeries<T> $repository */
    private function __construct(?MutableSeries $repository = null)
    {
        $this->repository = $repository ?? MutableArraySeries::new();
    }

    /**
     * @return self<T>
     */
    public static function new(): self
    {
        return new self();
    }

    /**
     * @param array<T> $data
     * @return self<T>
     */
    public static function fromArray(array $data): self
    {
        // TODO: array unique does not quite work how we want it here (strict comparison, implement own unique in Series)
        $unique = array_unique($data);
        $series = MutableArraySeries::fromArray($unique);
        return new self($series);
    }

    public function isEmpty(): bool
    {
        return $this->count() === 0;
    }

    public function count(): int
    {
        return count($this->repository);
    }

    public function getIterator(): Traversable
    {
        foreach ($this->repository as $item) {
            yield $item;
        }
    }

    /**
     * @param T $element
     */
    public function contains(mixed $element): bool
    {
        return in_array($element, $this->repository, true);
    }

    /**
     * @param T $element
     */
    public function add(mixed $element): bool
    {
        if ($this->contains($element)) {
            return false;
        }

        $this->repository[] = $element;
        return true;
    }

    /**
     * @param T $element
     */
    public function remove(mixed $element): bool
    {
        $elementIndex = array_search($element, $this->repository, true);

        if ($elementIndex === false) {
            return false;
        }

        unset($this->repository[$elementIndex]);
        return true;
    }
}
