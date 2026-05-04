<?php

namespace RubenMartinDev\PrestashopModuleHookBus\Tests\Unit;

use PHPUnit\Framework\TestCase;
use PHPUnit_Framework_MockObject_MockObject;
use RubenMartinDev\PrestashopModuleHookBus\Handler\HookHandlerInterface;
use RubenMartinDev\PrestashopModuleHookBus\HookBus;
use RubenMartinDev\PrestashopModuleHookBus\Locator\HandlerLocatorInterface;

class HookBusTest extends TestCase
{
    public function testDispatch()
    {
        $handler = $this->createMock(HookHandlerInterface::class);

        $handler->method('handle')->willReturn('dispatched');

        /** @var HandlerLocatorInterface&PHPUnit_Framework_MockObject_MockObject */
        $locator = $this->createMock(HandlerLocatorInterface::class);

        $locator->method('getHandlerForHook')->willReturn($handler);

        $hookBus = new HookBus($locator);

        $result = $hookBus->dispatch('displayHeader', ['param1' => 'value1']);

        $this->assertSame('dispatched', $result);
    }
}
