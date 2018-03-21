<?php

namespace Ekyna\Bundle\PayumCybermutBundle;

use Ekyna\Bundle\PayumCybermutBundle\DependencyInjection\Compiler\RegisterGatewayPass;
use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * Class EkynaPayumCybermutBundleTest
 * @package Ekyna\Bundle\PayumCybermutBundle
 * @author  Etienne Dauvergne <contact@ekyna.com>
 */
class EkynaPayumCybermutBundleTest extends TestCase
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

        $bundle = new EkynaPayumCybermutBundle();
        $bundle->build($container);
    }
}
