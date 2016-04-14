<?php

namespace ArsThanea\KunstmaanAlgoliaBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{

    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('kunstmaan_algolia');

        $client = $rootNode->children()->arrayNode('client');
        $client->children()->scalarNode('app_id')->isRequired();
        $client->children()->scalarNode('app_secret')->isRequired();
        $client->children()->scalarNode('public_key')->defaultNull();

        return $treeBuilder;

    }
}
