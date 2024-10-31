<?php

declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use Lsv\GoogleTranslationBundle\Translate\Client\TranslatorClientInterface;
use Lsv\GoogleTranslationBundle\Translate\GoogleTranslator;
use Lsv\GoogleTranslationBundle\Translate\Profiler\TranslatorProfilerInterface;
use Lsv\GoogleTranslationBundle\Translate\TranslatorInterface;

return static function (ContainerConfigurator $container): void {
    $container
        ->services()
            ->set(GoogleTranslator::class)
                ->args([
                    service(TranslatorClientInterface::class),
                    service(TranslatorProfilerInterface::class),
                ]);

    $container->services()->alias(TranslatorInterface::class, GoogleTranslator::class);
};
