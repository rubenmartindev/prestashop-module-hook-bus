<?php

namespace RubenMartinDev\PrestashopModuleHookBus\Locator;

interface AppendableHandlerLocatorInterface
{
    /**
     * @param string $hookName
     * @param mixed $handler
     *
     * @return static
     */
    public function addHandler($hookName, $handler);
}
