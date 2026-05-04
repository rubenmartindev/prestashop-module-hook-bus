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
    public function getHandlerForHook($hookName)
    {
        $handler = \call_user_func($this->callable, $hookName);

        if (null === $handler) {
            throw MissingHandlerException::forHook($hookName);
        }

        return $handler;
    }
}
