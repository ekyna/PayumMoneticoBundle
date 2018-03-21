<?php

namespace Ekyna\Bundle\PayumCybermutBundle;

use Ekyna\Bundle\PayumCybermutBundle\DependencyInjection\Compiler\RegisterGatewayPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * Class EkynaPayumCybermutBundle
 * @package Ekyna\Bundle\PayumCybermutBundle
 * @author  Etienne Dauvergne <contact@ekyna.com>
 */
class EkynaPayumCybermutBundle extends Bundle
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
