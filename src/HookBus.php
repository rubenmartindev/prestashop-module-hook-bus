<?php

namespace RubenMartinDev\PrestashopModuleHookBus;

use RubenMartinDev\PrestashopModuleHookBus\Handler\HookHandlerInterface;

class HookBus implements HookBusInterface
{
    /** @var array<string, HookHandlerInterface> */
    private $handlers = [];

    /**
     * @param iterable<HookHandlerInterface> $handlers
     */
    public function __construct($handlers = [])
    {
        foreach ($handlers as $handler) {
            $this->addHandler($handler);
        }
    }

    /**
     * {@inheritDoc}
     */
    public function addHandler(HookHandlerInterface $handler)
    {
        $this->handlers[$handler->getHookName()] = $handler;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function getHandler($hookName)
    {
        return isset($this->handlers[$hookName]) ? $this->handlers[$hookName] : null;
    }

    /**
     * {@inheritDoc}
     */
    public function removeHandler($hookName)
    {
        if (isset($this->handlers[$hookName])) {
            unset($this->handlers[$hookName]);
        }

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function getHandlers()
    {
        return $this->handlers;
    }

    /**
     * {@inheritDoc}
     */
    public function dispatch($hookName, array $params = [])
    {
        return;
    }
}
