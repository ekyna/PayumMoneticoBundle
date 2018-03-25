<?php

namespace Ekyna\Bundle\PayumMoneticoBundle;

use Ekyna\Bundle\PayumMoneticoBundle\DependencyInjection\Compiler\RegisterGatewayPass;
use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * Class EkynaPayumMoneticoBundleTest
 * @package Ekyna\Bundle\PayumMoneticoBundle
 * @author  Etienne Dauvergne <contact@ekyna.com>
 */
class EkynaPayumMoneticoBundleTest extends TestCase
{
    public function testRegisterGatewayPassToContainerBuilder()
    {
        /** @var \PHPUnit_Framework_MockObject_MockObject|ContainerBuilder $container */
        $container = $this
            ->getMockBuilder(ContainerBuilder::class)
            ->getMock();

        $container
            ->expects($this->at(0))
            ->method('addCompilerPass')
            ->with($this->isInstanceOf(RegisterGatewayPass::class));

        $bundle = new EkynaPayumMoneticoBundle();
        $bundle->build($container);
    }
}
