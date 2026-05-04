<?php

namespace RubenMartinDev\PrestashopModuleHookBus\Identifier;

interface HookIdentifierInterface
{
    /**
     * Identifies the name of the hook
     *
     * @param string $hookName
     *
     * @return string
     *
     * @throws UnresolvedHookIdentifierException
     */
    public function identify($hookName);
}
