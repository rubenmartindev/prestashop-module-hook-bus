<?php

use RubenMartinDev\PrestashopModuleHookBus\Tests\Stubs\Symfony\Component\DependencyInjection\ContainerInterface;

// Composer
require_once __DIR__ . '/../vendor/autoload.php';

$stubs = [
    ContainerInterface::class => 'Symfony\Component\DependencyInjection\ContainerInterface',
];

foreach ($stubs as $stubClassName => $alias) {
    if (!class_exists($alias)) {
        class_alias($stubClassName, $alias);
    }
}
