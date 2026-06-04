<?php

namespace RubenMartinDev\PrestashopModuleHookBus\Handler;

interface NamedHandlerInterface extends HookHandlerInterface
{
    /**
     * Returns the name of the identity
     *
     * @return string
     */
    public static function getIdentityName();
}
