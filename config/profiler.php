<?php

declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use Lsv\GoogleTranslationBundle\Translate\Profiler\GoogleTranslatorProfiler;
use Lsv\GoogleTranslationBundle\Translate\Profiler\TranslatorProfilerInterface;

return static function (ContainerConfigurator $container): void {
    $container->services()
        ->set(GoogleTranslatorProfiler::class)
            ->args([service('debug.stopwatch')->nullOnInvalid()]);

    $container->services()->alias(TranslatorProfilerInterface::class, GoogleTranslatorProfiler::class);
};
