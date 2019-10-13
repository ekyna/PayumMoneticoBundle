<?php

/** @var \Composer\Autoload\ClassLoader $loader */
if (!$loader = @include __DIR__.'/../vendor/autoload.php') {
    echo <<<EOM
You must set up the project dependencies by running the following commands:
    curl -s http://getcomposer.org/installer | php
    php composer.phar install --dev
EOM;
    exit(1);
}

$loader->addPsr4('Ekyna\\Bundle\\PayumMoneticoBundle\\', __DIR__);
$loader->addPsr4('App\\', __DIR__ . '/Functional/App');
