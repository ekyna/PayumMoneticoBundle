<?php

namespace Ekyna\Bundle\PayumMoneticoBundle;

use Ekyna\Bundle\PayumMoneticoBundle\DependencyInjection\Compiler\RegisterGatewayPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * Class EkynaPayumMoneticoBundle
 * @package Ekyna\Bundle\PayumMoneticoBundle
 * @author  Etienne Dauvergne <contact@ekyna.com>
 */
class EkynaPayumMoneticoBundle extends Bundle
{
    /**
     * @inheritdoc
     */
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $container->addCompilerPass(new RegisterGatewayPass());
    }
}
