<?php

namespace RubenMartinDev\PrestashopModuleHookBus\Identifier;

use RubenMartinDev\PrestashopModuleHookBus\Identifier\Exception\UnresolvedHookIdentifierException;

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
