<?php

declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use Lsv\GoogleTranslationBundle\Command\DetectCommand;
use Lsv\GoogleTranslationBundle\Command\TranslateCommand;
use Lsv\GoogleTranslationBundle\Translate\TranslatorInterface;

return static function (ContainerConfigurator $container): void {
    $container->services()
        ->set(TranslateCommand::class)
        ->tag('console.command')
        ->args([service(TranslatorInterface::class)]);

    $container->services()
        ->set(DetectCommand::class)
        ->tag('console.command')
        ->args([service(TranslatorInterface::class)]);
};
