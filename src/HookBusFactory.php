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
     * @param HookIdentifierInterface $hookIdentifier
     * @param iterable<string, HookHandlerInterface> $handlers
     *
     * @return HookBusInterface
     */
    public static function createWithArray(
        $hookIdentifier,
        $handlers
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
     * @param HookIdentifierInterface $hookIdentifier
     * @param callable $callable
     *
     * @return HookBusInterface
     */
    public static function createWithCallable(
        $hookIdentifier,
        callable $callable
    ) {
        return self::create(
            $hookIdentifier,
            new CallableLocator($callable)
        );
    }

    /**
     * @param ContainerInterface $container
     * @param HookIdentifierInterface $hookIdentifier
     * @param array<string, string> $handlers
     *
     * @return HookBusInterface
     */
    public static function createWithContainer(
        ContainerInterface $container,
        $hookIdentifier,
        $handlers
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
