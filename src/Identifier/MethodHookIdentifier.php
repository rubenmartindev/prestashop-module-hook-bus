<?php

namespace RubenMartinDev\PrestashopModuleHookBus\Identifier;

use RubenMartinDev\PrestashopModuleHookBus\Identifier\Exception\UnresolvedHookIdentifierException;

class MethodHookIdentifier implements HookIdentifierInterface
{
    /**
     * {@inheritDoc}
     */
    public function identify($hookName)
    {
        if (false == \preg_match('/^hook/i', $hookName)) {
            throw UnresolvedHookIdentifierException::forHookName($hookName);
        }

        $hookName = \preg_replace('/^hook/i', '', $hookName);
        $hookName = \lcfirst($hookName);

        return $hookName;
    }
}
