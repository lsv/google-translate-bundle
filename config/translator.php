<?php

declare(strict_types=1);

/**
 * Copyright (c) 2024-2026 Martin Aarhof
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 *
 * @see https://github.com/lsv/google-translate-bundle/blob/master/LICENSE
 *
 */

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
