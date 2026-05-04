<?php

namespace RubenMartinDev\PrestashopModuleHookBus\Handler;

interface HookHandlerInterface
{
    /**
     * @param array $params
     *
     * @return mixed
     */
    public function handle(array $params = []);
}
