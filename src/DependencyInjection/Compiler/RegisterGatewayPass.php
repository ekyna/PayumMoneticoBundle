<?php

namespace Ekyna\Bundle\PayumCybermutBundle\DependencyInjection\Compiler;

use Ekyna\Component\Payum\Cybermut\CybermutGatewayFactory;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Parameter;

/**
 * Class RegisterGatewayPass
 * @package Ekyna\Bundle\PayumCybermutBundle
 * @author  Etienne Dauvergne <contact@ekyna.com>
 */
class RegisterGatewayPass implements CompilerPassInterface
{
    /**
     * @inheritdoc
     */
    public function process(ContainerBuilder $container)
    {
        if (!$container->hasDefinition('payum.builder')) {
            return;
        }

        $defaultConfig = [
            'payum.api_config' => new Parameter('ekyna_payum_cybermut.api_config'),
        ];

        $payumBuilder = $container->getDefinition('payum.builder');
        $payumBuilder->addMethodCall('addGatewayFactoryConfig', ['cybermut', $defaultConfig]);
        $payumBuilder->addMethodCall('addGatewayFactory', ['cybermut', [CybermutGatewayFactory::class, 'build']]);
    }
}

