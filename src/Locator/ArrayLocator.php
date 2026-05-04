<?php

namespace RubenMartinDev\PrestashopModuleHookBus\Locator;

use RubenMartinDev\PrestashopModuleHookBus\Handler\HookHandlerInterface;
use RubenMartinDev\PrestashopModuleHookBus\Locator\Exception\MissingHandlerException;

class ArrayLocator implements HandlerLocatorInterface, AppendableHandlerLocatorInterface
{
    /** @var array<string, object> */
    private $handlers = [];

    /**
     * {@inheritDoc}
     *
     * @param HookHandlerInterface $handler
     */
    public function addHandler($hookName, $handler)
    {
        $this->handlers[$hookName] = $handler;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function getHandlerForHook($hookName)
    {
        if (!isset($this->handlers[$hookName])) {
            throw MissingHandlerException::forHook($hookName);
        }

        return $this->handlers[$hookName];
    }
}
