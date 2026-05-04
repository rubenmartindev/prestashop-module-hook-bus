<?php

namespace RubenMartinDev\PrestashopModuleHookBus\Identifier;

use RubenMartinDev\PrestashopModuleHookBus\Identifier\Exception\UnresolvedHookIdentifierException;

class CallableIdentifier implements HookIdentifierInterface
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
    public function identify($hookName)
    {
        $handler = \call_user_func($this->callable, $hookName);

        if (null === $handler) {
            throw UnresolvedHookIdentifierException::forHookName($hookName);
        }

        return $handler;
    }
}
