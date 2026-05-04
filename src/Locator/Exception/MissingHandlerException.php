<?php

namespace RubenMartinDev\PrestashopModuleHookBus\Locator\Exception;

use RubenMartinDev\PrestashopModuleHookBus\Exception\HookBusException;

class MissingHandlerException extends HookBusException
{
    /** @var string */
    private $identity;

    /**
     * @param string $identity
     *
     * @return static
     */
    public static function forIdentity($identity)
    {
        $exception = new static(\sprintf('No handlers registered for identity hook [%s]', $identity));

        $exception->identity = $identity;

        return $exception;
    }

    /**
     * @return string
     */
    public function getIdentity()
    {
        return $this->identity;
    }
}
