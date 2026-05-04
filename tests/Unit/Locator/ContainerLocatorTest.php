<?php

namespace RubenMartinDev\PrestashopModuleHookBus\Tests\Unit\Locator;

use Exception;
use PHPUnit_Framework_MockObject_MockObject;
use Psr\Container\ContainerInterface;
use RubenMartinDev\PrestashopModuleHookBus\Handler\HookHandlerInterface;
use RubenMartinDev\PrestashopModuleHookBus\Locator\ContainerLocator;

class ContainerLocatorTest extends AbstractLocatorTestCase
{
    /** @var ContainerLocator */
    private $locator;

    /** @var HookHandlerInterface */
    private $handler;

    protected function setUp()
    {
        parent::setUp();

        $this->handler = $this->createHookHandlerMock();

        /** @var ContainerInterface&PHPUnit_Framework_MockObject_MockObject */
        $container = $this->createMock(ContainerInterface::class);

        $container->method('get')->willReturnCallback(function ($serviceId) {
            if ($serviceId === get_class($this->handler)) {
                return $this->handler;
            }

            throw new Exception();
        });

        $this->locator = new ContainerLocator($container);
    }

    public function testAddHandler()
    {
        $this->locator->addHandler('displayHeader', get_class($this->handler));

        $this->assertSame($this->handler, $this->locator->getHandlerForIdentity('displayHeader'));
    }

    public function testGetHandlerForIdentityThrowsExceptionWhenNotFound()
    {
        $this->expectException(Exception::class);

        $this->locator->getHandlerForIdentity('nonExistentHook');
    }

    public function testGetHandlerForIdentityReturnsHandlerWhenFound()
    {
        $this->locator->addHandler('displayHeader', get_class($this->handler));

        $this->assertSame($this->handler, $this->locator->getHandlerForIdentity('displayHeader'));
    }
}
