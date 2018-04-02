<?php

namespace Ekyna\Bundle\PayumMoneticoBundle\DependencyInjection\Compiler;

use Ekyna\Bundle\PayumMoneticoBundle\Action\CommerceConvertAction;
use Ekyna\Component\Payum\Monetico\MoneticoGatewayFactory;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Parameter;
use Symfony\Component\DependencyInjection\Definition;

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

        $this->registerFactory($container);
        $this->registerActions($container);
    }

    /**
     * Registers the gateway factory.
     *
     * @param ContainerBuilder $container
     */
    private function registerFactory(ContainerBuilder $container)
    {
        $payumBuilder = $container->getDefinition('payum.builder');
        $payumBuilder->addMethodCall('addGatewayFactoryConfig', ['monetico', new Parameter('ekyna_payum_monetico.api_config')]);
        $payumBuilder->addMethodCall('addGatewayFactory', ['monetico', [MoneticoGatewayFactory::class, 'build']]);
    }

    /**
     * Registers actions.
     *
     * @param ContainerBuilder $container
     */
    private function registerActions(ContainerBuilder $container)
    {
        // Only for EkynaCommerceBundle
        if (!$container->hasDefinition('ekyna_commerce.checkout.payment_manager')) {
            return;
        }

        // Commerce convert payment action
        $definition = new Definition(CommerceConvertAction::class);
        $definition->addTag('payum.action', ['factory' => 'monetico', 'prepend' => true]);
        $container->setDefinition('ekyna_commerce.payum.action.monetico.convert_payment', $definition);
    }
}

