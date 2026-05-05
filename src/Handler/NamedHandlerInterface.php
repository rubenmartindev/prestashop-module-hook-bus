<?php

namespace RubenMartinDev\PrestashopModuleHookBus\Handler;

interface NamedHandlerInterface extends HookHandlerInterface
{
    /**
     * Returns the name of the hook
     *
     * @return string
     */
    public static function getHookName();
}
