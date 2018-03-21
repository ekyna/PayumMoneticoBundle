<?php

namespace Ekyna\Bundle\PayumCybermutBundle\DependencyInjection\Compiler;

use Ekyna\Component\Payum\Cybermut\CybermutGatewayFactory;
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
            ->with('addGatewayFactoryConfig', ['cybermut', ['payum.api_config' => new Parameter('ekyna_payum_cybermut.api_config')]]);

        $definition
            ->expects($this->at(1))
            ->method('addMethodCall')
            ->with('addGatewayFactory', ['cybermut', [CybermutGatewayFactory::class, 'build']]);

        $pass = new RegisterGatewayPass();
        $pass->process($container);
    }
}
