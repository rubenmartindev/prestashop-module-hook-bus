<?php

namespace RubenMartinDev\PrestashopModuleHookBus\Handler;

interface HookHandlerInterface
{
    /**
     * @return string
     */
    public function getHookName();

    /**
     * @param array $params
     *
     * @return mixed
     */
    public function handle(array $params = []);
}
