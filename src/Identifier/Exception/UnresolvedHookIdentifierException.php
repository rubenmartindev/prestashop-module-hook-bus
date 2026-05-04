<?php

namespace RubenMartinDev\PrestashopModuleHookBus\Identifier\Exception;

use RubenMartinDev\PrestashopModuleHookBus\Exception\HookBusException;

class UnresolvedHookIdentifierException extends HookBusException
{
    /** @var mixed */
    private $hookName;

    /**
     * @param mixed $hookName
     *
     * @return static
     */
    public static function forHookName($hookName)
    {
        $type = \is_object($hookName) ? \get_class($hookName) : \gettype($hookName);

        $exception = new static(\sprintf('The hook name could not be identified from [%s]', $type));

        $exception->hookName = $hookName;

        return $exception;
    }

    /**
     * @return mixed
     */
    public function getHookName()
    {
        return $this->hookName;
    }
}
