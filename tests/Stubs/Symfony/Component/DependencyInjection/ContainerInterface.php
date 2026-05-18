<?php

namespace RubenMartinDev\PrestashopModuleHookBus\Tests\Stubs\Symfony\Component\DependencyInjection;

/**
 * @see \Symfony\Component\DependencyInjection\ContainerInterface
 */
interface ContainerInterface
{
    const EXCEPTION_ON_INVALID_REFERENCE = 1;

    /**
     * @see \Symfony\Component\DependencyInjection\ContainerInterface::get()
     */
    public function get($id, $invalidBehavior = self::EXCEPTION_ON_INVALID_REFERENCE);

    /**
     * @see \Symfony\Component\DependencyInjection\ContainerInterface::has()
     */
    public function has($id);
}
