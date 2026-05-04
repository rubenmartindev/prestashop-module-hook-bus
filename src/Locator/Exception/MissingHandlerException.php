<?php

namespace RubenMartinDev\PrestashopModuleHookBus\Locator\Exception;

use RubenMartinDev\PrestashopModuleHookBus\Exception\HookBusException;

class MissingHandlerException extends HookBusException
{
    /** @var string */
    private $hookName;

    /**
     * @param string $hookName
     *
     * @return static
     */
    public static function forHook($hookName)
    {
        $exception = new static(\sprintf('Missing handler for hook %s', $hookName));

        $exception->hookName = $hookName;

        return $exception;
    }

    /**
     * @return string
     */
    public function getHookName()
    {
        return $this->hookName;
    }
}
