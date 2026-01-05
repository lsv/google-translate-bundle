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
