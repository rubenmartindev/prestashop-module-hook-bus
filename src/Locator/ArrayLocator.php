<?php

namespace RubenMartinDev\PrestashopModuleHookBus\Locator;

use RubenMartinDev\PrestashopModuleHookBus\Handler\HookHandlerInterface;
use RubenMartinDev\PrestashopModuleHookBus\Locator\Exception\MissingHandlerException;

class ArrayLocator implements AppendableHandlerLocatorInterface
{
    /** @var array<string, object> */
    private $handlers = [];

    /**
     * {@inheritDoc}
     *
     * @param HookHandlerInterface $handler
     */
    public function addHandler($identity, $handler)
    {
        $this->handlers[$identity] = $handler;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function getHandlerForIdentity($identity)
    {
        if (!isset($this->handlers[$identity])) {
            throw MissingHandlerException::forIdentity($identity);
        }

        return $this->handlers[$identity];
    }
}
