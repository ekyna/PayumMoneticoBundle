<?php

namespace Ekyna\Bundle\PayumMoneticoBundle\DependencyInjection;

use Ekyna\Component\Payum\Monetico\Api\Api;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;
use Symfony\Component\HttpKernel\Kernel;

/**
 * Class Configuration
 * @package Ekyna\Bundle\PayumMoneticoBundle
 * @author  Etienne Dauvergne <contact@ekyna.com>
 */
class Configuration implements ConfigurationInterface
{
    /**
     * @inheritdoc
     */
    public function getConfigTreeBuilder()
    {
        if (version_compare(Kernel::VERSION, '4.0.0') >= 0 ) {
            $treeBuilder = new TreeBuilder('ekyna_payum_monetico');
            $root = $treeBuilder->getRootNode();
        } else {
            $treeBuilder = new TreeBuilder();
            $root = $treeBuilder->root('ekyna_payum_monetico');
        }

        $this->addApiSection($root);

        return $treeBuilder;
    }

    /**
     * Adds the api configuration section.
     *
     * @param ArrayNodeDefinition $node
     */
    public function addApiSection(ArrayNodeDefinition $node)
    {
        $node
            ->children()
                ->arrayNode('api')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->enumNode('mode')
                            ->isRequired()
                            ->values([Api::MODE_TEST, Api::MODE_PRODUCTION])
                        ->end()
                        ->scalarNode('tpe')
                            ->isRequired()
                            ->cannotBeEmpty()
                        ->end()
                        ->scalarNode('key')
                            ->isRequired()
                            ->cannotBeEmpty()
                        ->end()
                        ->scalarNode('company')
                            ->isRequired()
                            ->cannotBeEmpty()
                        ->end()
                        ->booleanNode('debug')
                            ->defaultValue('%kernel.debug%')
                        ->end()
                    ->end()
                ->end()
            ->end();
    }
}
