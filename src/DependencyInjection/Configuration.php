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

namespace Lsv\GoogleTranslationBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder('lsv_google_translate');
        $root = $treeBuilder->getRootNode();

        // @formatter:off
        $root // @phpstan-ignore class.notFound
            ->children()
                ->scalarNode('google_api_key')->isRequired()->end()
            ->end();
        // @formatter:on

        return $treeBuilder;
    }
}
