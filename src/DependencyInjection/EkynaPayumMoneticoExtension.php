<?php

namespace Ekyna\Bundle\PayumMoneticoBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

/**
 * Class EkynaPayumMoneticoExtension
 * @package Ekyna\Bundle\PayumMoneticoBundle
 * @author  Etienne Dauvergne <contact@ekyna.com>
 */
class EkynaPayumMoneticoExtension extends Extension
{
    /**
     * @inheritdoc
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        // Api Config
        $container->setParameter('ekyna_payum_monetico.api_config', $config['api']);
    }
}
