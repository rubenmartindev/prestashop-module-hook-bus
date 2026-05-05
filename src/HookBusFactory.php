<?php

namespace RubenMartinDev\PrestashopModuleHookBus;

use Psr\Container\ContainerInterface;
use RubenMartinDev\PrestashopModuleHookBus\Handler\HookHandlerInterface;
use RubenMartinDev\PrestashopModuleHookBus\Handler\NamedHandlerInterface;
use RubenMartinDev\PrestashopModuleHookBus\Identifier\HookIdentifierInterface;
use RubenMartinDev\PrestashopModuleHookBus\Identifier\LiteralIdentifier;
use RubenMartinDev\PrestashopModuleHookBus\Locator\ArrayLocator;
use RubenMartinDev\PrestashopModuleHookBus\Locator\CallableLocator;
use RubenMartinDev\PrestashopModuleHookBus\Locator\ContainerLocator;
use RubenMartinDev\PrestashopModuleHookBus\Locator\HandlerLocatorInterface;

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
        $hookIdentifier = LiteralIdentifier::class
    ) {
        $arrayLocator = new ArrayLocator();

        foreach ($handlers as $identity => $handler) {
            if ($identity instanceof NamedHandlerInterface) {
                /** @var NamedHandlerInterface $handler */
                $identity = $handler::getHookName();
            }

            $arrayLocator->addHandler($identity, $handler);
        }

        return self::create(
            new $hookIdentifier,
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
        $hookIdentifier = LiteralIdentifier::class
    ) {
        return self::create(
            new $hookIdentifier,
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
        $hookIdentifier = LiteralIdentifier::class
    ) {
        $containerLocator = new ContainerLocator($container);

        foreach ($handlers as $identity => $serviceId) {
            if (\is_subclass_of($serviceId, NamedHandlerInterface::class)) {
                /** @var NamedHandlerInterface $serviceId */
                $identity = $serviceId::getHookName();
            }

            $containerLocator->addHandler($identity, $serviceId);
        }

        return self::create(
            new $hookIdentifier,
            $containerLocator
        );
    }
}
