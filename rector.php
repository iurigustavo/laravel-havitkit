<?php

use Rector\CodingStyle\Rector\Encapsed\EncapsedStringsToSprintfRector;
use Rector\Config\RectorConfig;
use Rector\Php83\Rector\ClassMethod\AddOverrideAttributeToOverriddenMethodsRector;
use Rector\Set\ValueObject\LevelSetList;
use Rector\Set\ValueObject\SetList;
use Rector\ValueObject\PhpVersion;
use RectorLaravel\Set\LaravelSetList;
use RectorLaravel\Set\Packages\Livewire\LivewireSetList;

return static function (RectorConfig $rectorConfig) {

    $rectorConfig->paths([
        __DIR__.'/app',
        __DIR__.'/bootstrap',
        __DIR__.'/config',
        __DIR__.'/database',
        __DIR__.'/public',
        __DIR__.'/resources',
    ]);

    $rectorConfig->skip([
        __DIR__.'/**/vendor/*',
        __DIR__.'/bootstrap/cache/*',
        AddOverrideAttributeToOverriddenMethodsRector::class,
        EncapsedStringsToSprintfRector::class,
    ]);

    $rectorConfig->sets([
        LaravelSetList::LARAVEL_110,
        LaravelSetList::LARAVEL_IF_HELPERS,
        LaravelSetList::LARAVEL_CODE_QUALITY,
        LivewireSetList::LIVEWIRE_30,
        LaravelSetList::LARAVEL_FACADE_ALIASES_TO_FULL_NAMES,
        SetList::DEAD_CODE,
        SetList::CODE_QUALITY,
        SetList::CODING_STYLE,
        SetList::PRIVATIZATION,
        SetList::EARLY_RETURN,
        SetList::STRICT_BOOLEANS,
        SetList::CARBON,
        SetList::TYPE_DECLARATION,
        LevelSetList::UP_TO_PHP_83,
    ]);

    $rectorConfig->phpVersion(PhpVersion::PHP_83);

    $rectorConfig->importNames();
};
