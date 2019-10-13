<?php

namespace App;

use Ekyna\Bundle\PayumMoneticoBundle\EkynaPayumMoneticoBundle;
use Payum\Bundle\PayumBundle\PayumBundle;
use Symfony\Bundle\FrameworkBundle\FrameworkBundle;
use Symfony\Bundle\TwigBundle\TwigBundle;
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\HttpKernel\Kernel;

class AppKernel extends Kernel
{
    public function registerBundles()
    {
        return [
            new FrameworkBundle(),
            new TwigBundle(),
            new PayumBundle(),
            new EkynaPayumMoneticoBundle(),
        ];
    }

    public function registerContainerConfiguration(LoaderInterface $loader)
    {
        $loader->load(__DIR__.'/config.yml');
    }

    public function getProjectDir()
    {
        return __DIR__;
    }

    public function getCacheDir()
    {
        return sys_get_temp_dir().'/EkynaPayumMonetico/cache/'.$this->environment;
    }

    public function getLogDir()
    {
        return sys_get_temp_dir().'/EkynaPayumMonetico/logs';
    }
}
