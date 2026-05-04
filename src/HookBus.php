<?php

namespace RubenMartinDev\PrestashopModuleHookBus;

use RubenMartinDev\PrestashopModuleHookBus\Identifier\HookIdentifierInterface;
use RubenMartinDev\PrestashopModuleHookBus\Locator\HandlerLocatorInterface;

class HookBus implements HookBusInterface
{
    /** @var HookIdentifierInterface */
    private $hookIdentifier;

    /** @var HandlerLocatorInterface */
    private $handlerLocator;

    public function __construct(
        HookIdentifierInterface $hookIdentifier,
        HandlerLocatorInterface $handlerLocator
    ) {
        $this->hookIdentifier = $hookIdentifier;
        $this->handlerLocator = $handlerLocator;
    }

    /**
     * {@inheritDoc}
     */
    public function dispatch($hookName, array $params = [])
    {
        $handler = $this->handlerLocator->getHandlerForIdentity(
            $this->hookIdentifier->identify($hookName)
        );

        return $handler->handle($params);
    }
}
