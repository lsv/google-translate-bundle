<?php

declare(strict_types=1);

/**
 * Copyright (c) 2024 Martin Aarhof
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 *
 * @see https://github.com/lsv/google-translate-bundle/blob/master/LICENSE
 *
 */

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
