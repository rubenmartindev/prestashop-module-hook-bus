<?php

namespace RubenMartinDev\PrestashopModuleHookBus\Locator;

interface AppendableHandlerLocatorInterface extends HandlerLocatorInterface
{
    /**
     * @param string $identity
     * @param mixed $handler
     *
     * @return static
     */
    public function addHandler($identity, $handler);
}
