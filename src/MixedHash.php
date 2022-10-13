<?php

declare(strict_types=1);

namespace AccumulatePHP;

use AccumulatePHP\Map\NotHashableException;
use JetBrains\PhpStorm\Pure;

/**
 * @template T
 */
final class MixedHash
{
    private function __construct(
        private readonly string|int $hash
    )
    {
    }

    /**
     * @param T $element
     * @return self<T>
     */
    public static function for(mixed $element): self
    {
        return new self(self::computeHash($element));
    }

    public static function computeHash(mixed $element): string|int
    {
        if ($element instanceof Hashable) {
            return $element->hashcode();
        }

        if (is_object($element)) {
            return spl_object_hash($element);
        }

        if (is_int($element) || is_string($element)) {
            return $element;
        }

        throw new NotHashableException();
    }

    public function getHash(): int|string
    {
        return $this->hash;
    }
}
