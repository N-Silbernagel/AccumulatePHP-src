<?php

declare(strict_types=1);

namespace Tests\Map;

interface MapTestContract
{
    public function it_should_be_creatable_from_assoc_array(): void;

    public function it_should_be_convertable_to_assoc_array(): void;

    public function it_should_ignore_non_scalar_keys_when_converting_to_assoc_array(): void;
}