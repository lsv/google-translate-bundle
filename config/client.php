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

use Lsv\GoogleTranslationBundle\Translate\Client\GoogleTranslatorClient;
use Lsv\GoogleTranslationBundle\Translate\Client\TranslatorClientInterface;

return static function (ContainerConfigurator $container): void {
    $container->services()
        ->set(GoogleTranslatorClient::class)
            ->args(['%lsv.google_translate.google_api_key%']);

    $container->services()->alias(TranslatorClientInterface::class, GoogleTranslatorClient::class);
};
