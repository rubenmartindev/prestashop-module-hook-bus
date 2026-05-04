<?php

namespace RubenMartinDev\PrestashopModuleHookBus;

interface HookBusInterface
{
    /**
     * @param string $hookName
     * @param array $params
     *
     * @return mixed
     */
    public function dispatch($hookName, array $params = []);
}
