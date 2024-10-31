<?php

declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use Lsv\GoogleTranslationBundle\DataCollector\TranslationDataCollector;
use Lsv\GoogleTranslationBundle\Translate\Profiler\TranslatorProfilerInterface;

return static function (ContainerConfigurator $container): void {
    $container->services()
        ->set(TranslationDataCollector::class)
            ->args([service(TranslatorProfilerInterface::class)])
            ->tag('data_collector', [
                'id' => TranslationDataCollector::class,
                'template' => 'Collector/translate.html.twig',
            ]);
};
