<?php

namespace RubenMartinDev\PrestashopModuleHookBus\Tests\Unit\Locator;

use RubenMartinDev\PrestashopModuleHookBus\Handler\HookHandlerInterface;
use RubenMartinDev\PrestashopModuleHookBus\Locator\ArrayLocator;
use RubenMartinDev\PrestashopModuleHookBus\Locator\Exception\MissingHandlerException;

class ArrayLocatorTest extends AbstractLocatorTestCase
{
    /** @var HookHandlerInterface */
    private $handler;

    /** @var ArrayLocator */
    private $locator;

    public function setUp()
    {
        parent::setup();

        $this->handler = $this->createHookHandlerMock();

        $this->locator = new ArrayLocator();
    }

    public function testAddHandler()
    {
        $this->locator->addHandler('displayHeader', $this->handler);

        $this->assertSame($this->handler, $this->locator->getHandlerForHook('displayHeader'));
    }

    public function testGetHandlerForHookThrowsExceptionWhenNotFound()
    {
        $this->expectException(MissingHandlerException::class);

        $this->locator->getHandlerForHook('nonExistentHook');
    }

    public function testGetHandlerForHookReturnsHookHandlerWhenFound()
    {
        $this->locator->addHandler('displayHeader', $this->handler);

        $this->assertSame($this->handler, $this->locator->getHandlerForHook('displayHeader'));
    }
}
