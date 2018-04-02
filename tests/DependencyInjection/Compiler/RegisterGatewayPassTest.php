<?php

namespace Ekyna\Bundle\PayumMoneticoBundle\DependencyInjection\Compiler;

use Ekyna\Component\Payum\Monetico\MoneticoGatewayFactory;
use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Parameter;

/**
 * Class RegisterGatewayPassTest
 * @author  Etienne Dauvergne <contact@ekyna.com>
 */
class RegisterGatewayPassTest extends TestCase
{
    public function testProcess()
    {
        /** @var \PHPUnit_Framework_MockObject_MockObject|ContainerBuilder $container */
        $container = $this
            ->getMockBuilder(ContainerBuilder::class)
            ->getMock();

        /** @var \PHPUnit_Framework_MockObject_MockObject|Definition $definition */
        $definition = $this
            ->getMockBuilder(Definition::class)
            ->getMock();

        $container
            ->expects($this->at(0))
            ->method('hasDefinition')
            ->with('payum.builder')
            ->willReturn(true);

        $container
            ->expects($this->at(1))
            ->method('getDefinition')
            ->with('payum.builder')
            ->willReturn($definition);

        $definition
            ->expects($this->at(0))
            ->method('addMethodCall')
            ->with('addGatewayFactoryConfig', ['monetico', new Parameter('ekyna_payum_monetico.api_config')]);

        $definition
            ->expects($this->at(1))
            ->method('addMethodCall')
            ->with('addGatewayFactory', ['monetico', [MoneticoGatewayFactory::class, 'build']]);

        $pass = new RegisterGatewayPass();
        $pass->process($container);
    }
}
