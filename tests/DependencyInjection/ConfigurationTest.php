<?php

namespace Ekyna\Bundle\PayumCybermutBundle\DependencyInjection;

use Ekyna\Component\Payum\Cybermut\Api\Api;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\Config\Definition\Processor;

/**
 * Class ConfigurationTest
 * @package Ekyna\Bundle\PayumCybermutBundle
 * @author  Etienne Dauvergne <contact@ekyna.com>
 */
class ConfigurationTest extends TestCase
{
    /**
     * @var Configuration
     */
    private $configuration;

    /**
     * @var Processor
     */
    private $processor;

    protected function setUp()
    {
        $this->configuration = new Configuration();
        $this->processor = new Processor();
    }

    protected function tearDown()
    {
        $this->configuration = null;
        $this->processor = null;
    }

    /**
     * @param array $config
     *
     * @dataProvider provideValidConfigs
     */
    public function testValidApiConfig(array $config)
    {
        $this->processor->processConfiguration($this->configuration, [
            'ekyna_payum_cybermut' => [
                'api' => $config,
            ],
        ]);
    }

    /**
     * @param array $config
     *
     * @dataProvider provideInvalidConfigs
     */
    public function testInvalidApiConfig(array $config)
    {
        $this->expectException(Exception::class);

        $this->processor->processConfiguration($this->configuration, [
            'ekyna_payum_cybermut' => [
                'api' => $config,
            ],
        ]);
    }

    public function provideValidConfigs()
    {
        return [
            [[
                'bank'    => Api::BANK_CM,
                'mode'    => Api::MODE_PRODUCTION,
                'tpe'     => '1324567890',
                'key'     => '1234567890',
                'company' => 'foobar',
                'debug'   => true,
            ]],
            [[
                'bank'    => Api::BANK_CIC,
                'mode'    => Api::MODE_TEST,
                'tpe'     => 'abc_def_ghi',
                'key'     => '1234567890',
                'company' => 'Ekyna',
                'debug'   => false,
            ]],
            [[
                'bank'    => Api::BANK_OBC,
                'mode'    => Api::MODE_PRODUCTION,
                'tpe'     => '1234567890',
                'key'     => 'abc_def_ghi',
                'company' => 'Cybermut',
            ]],
        ];
    }

    public function provideInvalidConfigs()
    {
        return [
            [[
                'mode'    => Api::MODE_PRODUCTION,
                'tpe'     => '1324567890',
                'key'     => '1234567890',
                'company' => 'foobar',
                'debug'   => true,
            ]],
            [[
                'bank'    => Api::BANK_CM,
                'tpe'     => '1324567890',
                'key'     => '1234567890',
                'company' => 'foobar',
                'debug'   => true,
            ]],
            [[
                'bank'    => Api::BANK_CM,
                'mode'    => Api::MODE_PRODUCTION,
                'key'     => '1234567890',
                'company' => 'foobar',
                'debug'   => true,
            ]],
            [[
                'bank'    => Api::BANK_CM,
                'mode'    => Api::MODE_PRODUCTION,
                'tpe'     => '1324567890',
                'key'     => '1234567890',
                'debug'   => true,
            ]],
            [[
                'bank'    => Api::BANK_CM,
                'mode'    => Api::MODE_PRODUCTION,
                'tpe'     => '',
                'key'     => '1234567890',
                'company' => 'foobar',
                'debug'   => true,
            ]],
            [[
                'bank'    => 'foo',
                'mode'    => Api::MODE_PRODUCTION,
                'tpe'     => '1324567890',
                'key'     => '1234567890',
                'company' => 'foobar',
                'debug'   => true,
            ]],
            [[
                'bank'    => Api::BANK_CM,
                'mode'    => 'bar',
                'tpe'     => '1324567890',
                'key'     => '1234567890',
                'company' => 'foobar',
                'debug'   => true,
            ]],
        ];
    }
}
