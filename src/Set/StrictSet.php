<?php

declare(strict_types=1);

namespace AccumulatePHP\Set;

use AccumulatePHP\Series\ArraySeries;
use AccumulatePHP\Series\Series;
use IteratorAggregate;
use JetBrains\PhpStorm\Pure;
use Traversable;

/**
 * @template T
 * @implements Set<T>
 * @implements IteratorAggregate<int, T>
 */
final class StrictSet implements Set, IteratorAggregate
{
    /** @var Series<T>  */
    private readonly Series $repository;

    /** @param Series<T>|null $repository */
    #[Pure]
    private function __construct(?Series $repository = null)
    {
        $this->repository = $repository ?? ArraySeries::new();
    }

    /**
     * @return self<T>
     */
    #[Pure]
    public static function new(): self
    {
        return new self();
    }

    /**
     * @param array<T> $array
     * @return self<T>
     */
    public static function fromArray(array $array): self
    {
        /** @var Series<T> $encounteredValues */
        $encounteredValues = ArraySeries::new();

        foreach ($array as $item) {
            if (!$encounteredValues->contains($item)) {
                $encounteredValues->add($item);
            }
        }

        return new self($encounteredValues);
    }

    /**
     * @param T ...$items
     * @return self<T>
     */
    public static function of(...$items): self
    {
        return self::fromArray($items);
    }

    #[Pure]
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
        return $this->repository->contains($element);
    }

    /**
     * @param T $element
     */
    public function add(mixed $element): bool
    {
        if ($this->contains($element)) {
            return false;
        }

        $this->repository->add($element);
        return true;
    }

    /**
     * @param T $element
     */
    public function remove(mixed $element): bool
    {
        $index = $this->repository->findIndex(fn(mixed $item) => $item === $element);

        if (is_null($index)) {
            return false;
        }

        $this->repository->remove($index);
        return true;
    }

    public function toArray(): array
    {
        return $this->repository->toArray();
    }
}
