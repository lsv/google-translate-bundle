<?php

declare(strict_types=1);

namespace Lsv\GoogleTranslationBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder('lsv_google_translate');
        $root = $treeBuilder->getRootNode();

        $root
            ->children()
                ->scalarNode('google_api_key')->isRequired()->end()
            ->end();

        return $treeBuilder;
    }
}
