<?php

namespace Predanie\Bitrix24Bundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('predanie_bitrix24_monolog');

        $rootNode
            ->children()
                ->scalarNode('chat_id')
                    ->info('Bitrix24 chart id for error reporting')
                    ->defaultValue('1')
                ->end()
                ->scalarNode('user_id')
                    ->info('Bitrix24 reporters user id')
                    ->defaultValue('1')
                ->end()
                ->scalarNode('webhook')
                    ->info('Bitrix24 webhook unique code')
			        ->defaultValue('ABCDEFG')
                ->end()
            ->end();

        return $treeBuilder;
    }
}
