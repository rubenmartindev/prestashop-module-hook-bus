<?php

namespace RubenMartinDev\PrestashopModuleHookBus\Tests;

use PHPUnit_Framework_MockObject_MockObject;
use PHPUnit\Framework\TestCase;
use RubenMartinDev\PrestashopModuleHookBus\Handler\HookHandlerInterface;
use RubenMartinDev\PrestashopModuleHookBus\HookBusFactory;
use RubenMartinDev\PrestashopModuleHookBus\HookBusInterface;
use RubenMartinDev\PrestashopModuleHookBus\Identifier\HookIdentifierInterface;
use RubenMartinDev\PrestashopModuleHookBus\Identifier\LiteralIdentifier;
use RubenMartinDev\PrestashopModuleHookBus\Locator\HandlerLocatorInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class HookBusFactoryTest extends TestCase
{
    /** @var HookHandlerInterface */
    private $hookHandler;

    /** @var HookIdentifierInterface */
    private $hookIdentifier;

    protected function setUp()
    {
        parent::setUp();

        $this->hookHandler      = $this->createMock(HookHandlerInterface::class);
        $this->hookIdentifier   = $this->createMock(HookIdentifierInterface::class);
    }

    public function testCreate()
    {
        /** @var HandlerLocatorInterface&PHPUnit_Framework_MockObject_MockObject */
        $handlerLocator = $this->createMock(HandlerLocatorInterface::class);

        $hookBus = HookBusFactory::create(
            $this->hookIdentifier,
            $handlerLocator
        );

        $this->assertInstanceOf(HookBusInterface::class, $hookBus);
    }

    public function testCreateWithArrayReturnsHookBusWithoutHookIdentifier()
    {
        $hookBus = HookBusFactory::createWithArray(
            new LiteralIdentifier(),
            ['displayHeader' => $this->hookHandler]
        );

        $this->assertInstanceOf(HookBusInterface::class, $hookBus);
    }

    public function testCreateWithArrayReturnsHookBusWithIdentifier()
    {
        $hookBus = HookBusFactory::createWithArray(
            $this->hookIdentifier,
            ['displayHeader' => $this->hookHandler]
        );

        $this->assertInstanceOf(HookBusInterface::class, $hookBus);
    }

    public function testCreateWithCallableReturnsHookBusWithoutHookIdentifier()
    {
        $hookBus = HookBusFactory::createWithCallable(
            new LiteralIdentifier(),
            function () {
                return $this->hookHandler;
            }
        );

        $this->assertInstanceOf(HookBusInterface::class, $hookBus);
    }

    public function testCreateWithCallableReturnsHookBusWithIdentifier()
    {
        $hookBus = HookBusFactory::createWithCallable(
            $this->hookIdentifier,
            function () {
                return $this->hookHandler;
            }
        );

        $this->assertInstanceOf(HookBusInterface::class, $hookBus);
    }

    public function testCreateWithContainerReturnsHookBusWithoutHookIdentifier()
    {
        /** @var ContainerInterface&PHPUnit_Framework_MockObject_MockObject */
        $container = $this->createMock(ContainerInterface::class);

        $hookBus = HookBusFactory::createWithContainer(
            $container,
            new LiteralIdentifier(),
            ['hook.handler.displayHeader']
        );

        $this->assertInstanceOf(HookBusInterface::class, $hookBus);
    }

    public function testCreateWithContainerReturnsHookBusWithIdentifier()
    {
        /** @var ContainerInterface&PHPUnit_Framework_MockObject_MockObject */
        $container = $this->createMock(ContainerInterface::class);

        $hookBus = HookBusFactory::createWithContainer(
            $container,
            $this->hookIdentifier,
            ['hook.handler.displayHeader']
        );

        $this->assertInstanceOf(HookBusInterface::class, $hookBus);
    }
}
