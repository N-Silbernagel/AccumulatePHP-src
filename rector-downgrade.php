<?php

declare(strict_types=1);

use Rector\Set\ValueObject\DowngradeLevelSetList;
use Rector\Config\RectorConfig;

return function (RectorConfig $rectorConfig): void {
    $rectorConfig->paths([__DIR__ . '/src', __DIR__ . '/tests']);

    $rectorConfig->import(DowngradeLevelSetList::DOWN_TO_PHP_81);
    $rectorConfig->import(DowngradeLevelSetList::DOWN_TO_PHP_80);
};
