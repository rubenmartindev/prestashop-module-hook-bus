<?php

namespace RubenMartinDev\PrestashopModuleHookBus\Tests\Unit;

use ArrayIterator;
use PHPUnit\Framework\TestCase;
use PHPUnit_Framework_MockObject_MockObject;
use RubenMartinDev\PrestashopModuleHookBus\Handler\HookHandlerInterface;
use RubenMartinDev\PrestashopModuleHookBus\HookBus;

class HookBusTest extends TestCase
{
    public function testConstructorWithoutParameters()
    {
        $hookBus = new HookBus();

        $this->assertSame([], $hookBus->getHandlers());
    }

    public function testConstructorWithArray()
    {
        $handler1 = $this->createMockHandler('actionProductSave');
        $handler2 = $this->createMockHandler('actionCartUpdate');

        $hookBus = new HookBus([$handler1, $handler2]);

        $this->assertSame($handler1, $hookBus->getHandler('actionProductSave'));
        $this->assertSame($handler2, $hookBus->getHandler('actionCartUpdate'));
    }

    public function testConstructorWithIterator()
    {
        $handler1 = $this->createMockHandler('actionProductSave');
        $handler2 = $this->createMockHandler('actionCartUpdate');

        $iterator = new ArrayIterator([$handler1, $handler2]);

        $hookBus = new HookBus($iterator);

        $this->assertSame($handler1, $hookBus->getHandler('actionProductSave'));
        $this->assertSame($handler2, $hookBus->getHandler('actionCartUpdate'));
    }

    public function testAddHandler()
    {
        $hookBus = new HookBus();

        $handler = $this->createMockHandler('actionProductSave');

        $result = $hookBus->addHandler($handler);

        $this->assertSame($hookBus, $result);
        $this->assertSame($handler, $hookBus->getHandler('actionProductSave'));
    }

    public function testAddHandlerOverwritesHandlers()
    {
        $hookBus = new HookBus();

        $handler = $this->createMockHandler('actionCartUpdate');

        $handlerOverwrite1 = $this->createMockHandler('actionProductSave');
        $handlerOverwrite2 = $this->createMockHandler('actionProductSave');

        $hookBus->addHandler($handler);
        $hookBus->addHandler($handlerOverwrite1);
        $hookBus->addHandler($handlerOverwrite2);

        $this->assertCount(2, $hookBus->getHandlers());
        $this->assertSame($handler, $hookBus->getHandler('actionCartUpdate'));
        $this->assertSame($handlerOverwrite2, $hookBus->getHandler('actionProductSave'));
    }

    public function testGetHandlerReturnsNullWhenNotFound()
    {
        $hookBus = new HookBus();

        $this->assertNull($hookBus->getHandler('nonExistentHook'));
    }

    public function testGetHandlerReturnsHandlerWhenFound()
    {
        $hookBus = new HookBus();

        $handler = $this->createMockHandler('actionProductSave');

        $hookBus->addHandler($handler);

        $this->assertSame($handler, $hookBus->getHandler('actionProductSave'));
    }

    public function testRemoveHandlerWhenHandlerNotFound()
    {
        $hookBus = new HookBus();

        $result = $hookBus->removeHandler('nonExistentHook');

        $this->assertSame($hookBus, $result);
    }

    public function testRemoveHandlerWhenHandlerFound()
    {
        $hookBus = new HookBus();

        $handler = $this->createMockHandler('actionProductSave');

        $hookBus->addHandler($handler);

        $result = $hookBus->removeHandler('actionProductSave');

        $this->assertSame($hookBus, $result);
        $this->assertNull($hookBus->getHandler('actionProductSave'));
    }

    public function testGetHandlersReturnsEmptyArrayWhenNoHandlers()
    {
        $hookBus = new HookBus();

        $this->assertSame([], $hookBus->getHandlers());
    }

    public function testGetHandlersReturnsAllHandlers()
    {
        $hookBus = new HookBus();

        $handler1 = $this->createMockHandler('actionProductSave');
        $handler2 = $this->createMockHandler('actionCartUpdate');

        $hookBus->addHandler($handler1);
        $hookBus->addHandler($handler2);

        $handlers = $hookBus->getHandlers();

        $this->assertCount(2, $handlers);
        $this->assertSame($handler1, $handlers['actionProductSave']);
        $this->assertSame($handler2, $handlers['actionCartUpdate']);
    }

    /**
     * @param string $hookName
     *
     * @return HookHandlerInterface|PHPUnit_Framework_MockObject_MockObject
     */
    private function createMockHandler($hookName)
    {
        $handler = $this->createMock(HookHandlerInterface::class);
        $handler->method('getHookName')->willReturn($hookName);

        return $handler;
    }
}
