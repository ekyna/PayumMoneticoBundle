<?php

namespace Ekyna\Bundle\PayumCybermutBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

/**
 * Class EkynaPayumCybermutExtension
 * @package Ekyna\Bundle\PayumCybermutBundle
 * @author  Etienne Dauvergne <contact@ekyna.com>
 */
class EkynaPayumCybermutExtension extends Extension
{
    /**
     * @inheritdoc
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        // Api Config
        $container->setParameter('ekyna_payum_cybermut.api_config', $config['api']);
    }
}
