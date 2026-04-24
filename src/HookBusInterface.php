<?php

namespace RubenMartinDev\PrestashopModuleHookBus;

use RubenMartinDev\PrestashopModuleHookBus\Handler\HookHandlerInterface;

interface HookBusInterface
{
    /**
     * @param HookHandlerInterface $handler
     *
     * @return static
     */
    public function addHandler(HookHandlerInterface $handler);

    /**
     * @param string $hookName
     *
     * @return HookHandlerInterface|null
     */
    public function getHandler($hookName);

    /**
     * @param string $hookName
     *
     * @return static
     */
    public function removeHandler($hookName);

    /**
     * @return array<string, HookHandlerInterface>
     */
    public function getHandlers();

    /**
     * @param string $hookName
     * @param array $params
     *
     * @return mixed
     */
    public function dispatch($hookName, array $params = []);
}
