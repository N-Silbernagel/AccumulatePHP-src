<?php

declare(strict_types=1);

namespace Tests;

use AccumulatePHP\Map\NotHashableException;
use AccumulatePHP\MixedHash;
use PHPUnit\Framework\TestCase;
use Tests\Map\EqualHashable;

final class MixedHashTest extends TestCase
{
    /** @test */
    public function it_should_compute_to_given_int(): void
    {
        $mixedHash = MixedHash::for(2294605);

        self::assertSame(2294605, $mixedHash->getHash());
    }

    /** @test */
    public function it_should_compute_to_given_string(): void
    {
        $mixedHash = MixedHash::for('test');

        self::assertSame('test', $mixedHash->getHash());
    }

    /** @test */
    public function it_should_throw_for_float(): void
    {
        $this->expectException(NotHashableException::class);

        MixedHash::for(1.18);
    }

    /** @test */
    public function it_should_throw_for_bool(): void
    {
        $this->expectException(NotHashableException::class);

        MixedHash::for(false);
    }

    /** @test */
    public function it_should_throw_for_null(): void
    {
        $this->expectException(NotHashableException::class);

        MixedHash::for(null);
    }

    /** @test */
    public function it_should_throw_for_array(): void
    {
        $this->expectException(NotHashableException::class);

        MixedHash::for([]);
    }

    /** @test */
    public function it_should_throw_for_resource(): void
    {
        $resource = fopen(__DIR__ . '/teststream.txt', 'r');

        if ($resource === false) {
            self::fail('Could not open teststream file');
        }

        $this->expectException(NotHashableException::class);

        $mixedHash = MixedHash::for($resource);

        $mixedHash->getHash();
    }

    /** @test */
    public function it_should_return_object_hash_for_object(): void
    {
        $obj = (object)[];
        $mixedHash = MixedHash::for($obj);

        self::assertSame(spl_object_hash($obj), $mixedHash->getHash());

    }

    /** @test */
    public function it_should_return_hashcode_for_hashable(): void
    {
        $hashable = new EqualHashable('hello');
        $mixedHash = MixedHash::for($hashable);

        self::assertSame($hashable->hashcode(), $mixedHash->getHash());
    }
}
