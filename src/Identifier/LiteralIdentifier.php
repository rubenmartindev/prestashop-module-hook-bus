<?php

namespace RubenMartinDev\PrestashopModuleHookBus\Identifier;

class LiteralIdentifier implements HookIdentifierInterface
{
    /**
     * {@inheritDoc}
     */
    public function identify($hookName)
    {
        return $hookName;
    }
}
