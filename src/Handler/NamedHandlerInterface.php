<?php

namespace RubenMartinDev\PrestashopModuleHookBus\Handler;

interface NamedHandlerInterface
{
    /**
     * Returns the name of the hook
     *
     * @return string
     */
    public static function getHookName();
}
