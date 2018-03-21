<?php

namespace Ekyna\Bundle\PayumCybermutBundle\DependencyInjection;

use Ekyna\Component\Payum\Cybermut\Api\Api;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * Class Configuration
 * @package Ekyna\Bundle\PayumCybermutBundle
 * @author  Etienne Dauvergne <contact@ekyna.com>
 */
class Configuration implements ConfigurationInterface
{
    /**
     * @inheritdoc
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $root = $treeBuilder->root('ekyna_payum_cybermut');

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
                        ->enumNode('bank')
                            ->isRequired()
                            ->values([Api::BANK_CM, Api::BANK_CIC, Api::BANK_OBC])
                        ->end()
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
