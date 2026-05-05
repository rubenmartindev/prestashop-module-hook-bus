<?php

namespace RubenMartinDev\PrestashopModuleHookBus\Locator;

use Psr\Container\ContainerInterface;
use RubenMartinDev\PrestashopModuleHookBus\Locator\Exception\MissingHandlerException;

class ContainerLocator implements AppendableHandlerLocatorInterface
{
    /** @var ContainerInterface */
    private $container;

    /** @var array<string, string> */
    private $handlers = [];

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * {@inheritDoc}
     *
     * @param string $serviceId
     */
    public function addHandler($identity, $serviceId)
    {
        $this->handlers[$identity] = $serviceId;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function getHandlerForIdentity($identity)
    {
        if (!isset($this->handlers[$identity])) {
            throw MissingHandlerException::forIdentity($identity);
        }

        return $this->container->get($this->handlers[$identity]);
    }
}
