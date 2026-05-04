<?php

namespace RubenMartinDev\PrestashopModuleHookBus;

use RubenMartinDev\PrestashopModuleHookBus\Locator\HandlerLocatorInterface;

class HookBus implements HookBusInterface
{
    /** @var HandlerLocatorInterface */
    private $handlerLocator;

    public function __construct(
        HandlerLocatorInterface $handlerLocator
    ) {
        $this->handlerLocator = $handlerLocator;
    }

    /**
     * {@inheritDoc}
     */
    public function dispatch($hookName, array $params = [])
    {
        $handler = $this->handlerLocator->getHandlerForHook($hookName);

        return $handler->handle($params);
    }
}
