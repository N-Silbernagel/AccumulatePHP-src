<?php

declare(strict_types=1);

namespace AccumulatePHP\Map;

use RuntimeException;

final class UnsupportedHashMapKeyException extends RuntimeException
{
    public function __construct()
    {
        parent::__construct();
    }
}
