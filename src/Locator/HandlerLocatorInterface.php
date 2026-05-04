<?php

namespace RubenMartinDev\PrestashopModuleHookBus\Locator;

use RubenMartinDev\PrestashopModuleHookBus\Handler\HookHandlerInterface;
use RubenMartinDev\PrestashopModuleHookBus\Locator\Exception\MissingHandlerException;

interface HandlerLocatorInterface
{
    /**
     * Retrieves the handler for a specified identity
     *
     * @param string $identity
     *
     * @return HookHandlerInterface
     *
     * @throws MissingHandlerException
     */
    public function getHandlerForIdentity($identity);
}
