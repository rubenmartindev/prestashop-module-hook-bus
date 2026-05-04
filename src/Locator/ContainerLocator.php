<?php

namespace RubenMartinDev\PrestashopModuleHookBus\Locator;

use Psr\Container\ContainerInterface;
use RubenMartinDev\PrestashopModuleHookBus\Locator\Exception\MissingHandlerException;

class ContainerLocator implements HandlerLocatorInterface, AppendableHandlerLocatorInterface
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
    public function addHandler($hookName, $serviceId)
    {
        $this->handlers[$hookName] = $serviceId;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function getHandlerForHook($hookName)
    {
        if (!isset($this->handlers[$hookName])) {
            throw MissingHandlerException::forHook($hookName);
        }

        return $this->container->get($this->handlers[$hookName]);
    }
}
