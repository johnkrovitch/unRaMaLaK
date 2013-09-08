<?php

namespace Krovitch\UnramalakBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    /**
     * Generates the configuration tree builder.
     * @return \Symfony\Component\Config\Definition\Builder\TreeBuilder The tree builder
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('unramalak');

        $unit = $rootNode->children()->arrayNode('unit')->children();
        $unit->scalarNode('upload_dir')->cannotBeEmpty()->end();

        //$test = $rootNode->children()->scalarNode('test')->cannotBeEmpty()->end();

        return $treeBuilder;
    }
}