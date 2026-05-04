<?php

namespace RubenMartinDev\PrestashopModuleHookBus\Locator;

use RubenMartinDev\PrestashopModuleHookBus\Locator\Exception\MissingHandlerException;

class CallableLocator implements HandlerLocatorInterface
{
    /** @var callable */
    private $callable;

    /**
     * @param callable $callable
     */
    public function __construct(callable $callable)
    {
        $this->callable = $callable;
    }

    /**
     * {@inheritDoc}
     */
    public function getHandlerForIdentity($identity)
    {
        $handler = \call_user_func($this->callable, $identity);

        if (null === $handler) {
            throw MissingHandlerException::forIdentity($identity);
        }

        return $handler;
    }
}
