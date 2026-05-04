<?php

namespace RubenMartinDev\PrestashopModuleHookBus\Locator;

use RubenMartinDev\PrestashopModuleHookBus\Handler\HookHandlerInterface;
use RubenMartinDev\PrestashopModuleHookBus\Locator\Exception\MissingHandlerException;

interface HandlerLocatorInterface
{
    /**
     * Retrieves the handler for a specified hook
     *
     * @param string $hookName
     *
     * @return HookHandlerInterface
     *
     * @throws MissingHandlerException
     */
    public function getHandlerForHook($hookName);
}
