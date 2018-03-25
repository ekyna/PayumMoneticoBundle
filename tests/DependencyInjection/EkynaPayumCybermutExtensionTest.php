<?php

namespace Ekyna\Bundle\PayumMoneticoBundle\DependencyInjection;

use Ekyna\Component\Payum\Monetico\Api\Api;
use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * Class EkynaPayumMoneticoExtensionTest
 * @package Ekyna\Bundle\PayumMoneticoBundle
 * @author  Etienne Dauvergne <contact@ekyna.com>
 */
class EkynaPayumMoneticoExtensionTest extends TestCase
{
    public function testSetApiConfigAsContainerParameter()
    {
        $expectedApiConfig = [
            'bank'    => Api::BANK_CM,
            'mode'    => Api::MODE_PRODUCTION,
            'tpe'     => '1324567890',
            'key'     => '1234567890',
            'company' => 'foobar',
            'debug'   => true,
        ];

        /** @var \PHPUnit_Framework_MockObject_MockObject|ContainerBuilder $container */
        $container = $this
            ->getMockBuilder(ContainerBuilder::class)
            ->getMock();

        $container
            ->expects($this->at(0))
            ->method('setParameter')
            ->with('ekyna_payum_monetico.api_config', $expectedApiConfig);

        $extension = new EkynaPayumMoneticoExtension();
        $extension->load([
            'ekyna_payum_monetico' => [
                'api' => $expectedApiConfig,
            ],
        ], $container);


    }
}