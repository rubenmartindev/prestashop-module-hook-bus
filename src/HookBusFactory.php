<?php

namespace RubenMartinDev\PrestashopModuleHookBus;

use RubenMartinDev\PrestashopModuleHookBus\Handler\HookHandlerInterface;
use RubenMartinDev\PrestashopModuleHookBus\Handler\NamedHandlerInterface;
use RubenMartinDev\PrestashopModuleHookBus\Identifier\HookIdentifierInterface;
use RubenMartinDev\PrestashopModuleHookBus\Locator\ArrayLocator;
use RubenMartinDev\PrestashopModuleHookBus\Locator\CallableLocator;
use RubenMartinDev\PrestashopModuleHookBus\Locator\ContainerLocator;
use RubenMartinDev\PrestashopModuleHookBus\Locator\HandlerLocatorInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class HookBusFactory
{
    /**
     * @param HookIdentifierInterface $hookIdentifier
     * @param HandlerLocatorInterface $handlerLocator
     *
     * @return HookBusInterface
     */
    public static function create(
        HookIdentifierInterface $hookIdentifier,
        HandlerLocatorInterface $handlerLocator
    ) {
        return new HookBus($hookIdentifier, $handlerLocator);
    }

    /**
     * @param iterable<HookHandlerInterface> $handlers
     * @param HookIdentifierInterface $hookIdentifier
     *
     * @return HookBusInterface
     */
    public static function createWithArray(
        $handlers,
        $hookIdentifier
    ) {
        $arrayLocator = new ArrayLocator();

        foreach ($handlers as $identity => $handler) {
            if ($identity instanceof NamedHandlerInterface) {
                /** @var NamedHandlerInterface $handler */
                $identity = $handler::getIdentityName();
            }

            $arrayLocator->addHandler($identity, $handler);
        }

        return self::create(
            $hookIdentifier,
            $arrayLocator
        );
    }

    /**
     * @param callable $callable
     * @param HookIdentifierInterface $hookIdentifier
     *
     * @return HookBusInterface
     */
    public static function createWithCallable(
        callable $callable,
        $hookIdentifier
    ) {
        return self::create(
            $hookIdentifier,
            new CallableLocator($callable)
        );
    }

    /**
     * @param ContainerInterface $container
     * @param string[] $handlers
     * @param HookIdentifierInterface $hookIdentifier
     *
     * @return HookBusInterface
     */
    public static function createWithContainer(
        ContainerInterface $container,
        $handlers,
        $hookIdentifier
    ) {
        $containerLocator = new ContainerLocator($container);

        foreach ($handlers as $identity => $serviceId) {
            if (\is_subclass_of($serviceId, NamedHandlerInterface::class)) {
                /** @var NamedHandlerInterface $serviceId */
                $identity = $serviceId::getIdentityName();
            }

            $containerLocator->addHandler($identity, $serviceId);
        }

        return self::create(
            $hookIdentifier,
            $containerLocator
        );
    }
}
