<?php

namespace Ekyna\Bundle\PayumMoneticoBundle\DependencyInjection\Compiler;

use Ekyna\Component\Payum\Monetico\MoneticoGatewayFactory;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Parameter;

/**
 * Class RegisterGatewayPass
 * @package Ekyna\Bundle\PayumMoneticoBundle
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
            'payum.api_config' => new Parameter('ekyna_payum_monetico.api_config'),
        ];

        $payumBuilder = $container->getDefinition('payum.builder');
        $payumBuilder->addMethodCall('addGatewayFactoryConfig', ['monetico', $defaultConfig]);
        $payumBuilder->addMethodCall('addGatewayFactory', ['monetico', [MoneticoGatewayFactory::class, 'build']]);
    }
}

