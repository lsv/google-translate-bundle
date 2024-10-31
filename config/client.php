<?php

declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use Lsv\GoogleTranslationBundle\Translate\Client\GoogleTranslatorClient;
use Lsv\GoogleTranslationBundle\Translate\Client\TranslatorClientInterface;

return static function (ContainerConfigurator $container): void {
    $container->services()
        ->set(GoogleTranslatorClient::class)
            ->args(['%lsv.google_translate.google_api_key%']);

    $container->services()->alias(TranslatorClientInterface::class, GoogleTranslatorClient::class);
};
