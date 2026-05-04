<?php

namespace RubenMartinDev\PrestashopModuleHookBus\Tests\Locator;

use RubenMartinDev\PrestashopModuleHookBus\Handler\HookHandlerInterface;
use RubenMartinDev\PrestashopModuleHookBus\Locator\ArrayLocator;
use RubenMartinDev\PrestashopModuleHookBus\Locator\Exception\MissingHandlerException;

class ArrayLocatorTest extends AbstractLocatorTestCase
{
    /** @var HookHandlerInterface */
    private $handler;

    /** @var ArrayLocator */
    private $locator;

    protected function setUp()
    {
        parent::setup();

        $this->handler = $this->createHookHandlerMock();

        $this->locator = new ArrayLocator();
    }

    public function testAddHandler()
    {
        $this->locator->addHandler('displayHeader', $this->handler);

        $this->assertSame($this->handler, $this->locator->getHandlerForIdentity('displayHeader'));
    }

    public function testGetHandlerForIdentityThrowsExceptionWhenNotFound()
    {
        $this->expectException(MissingHandlerException::class);

        $this->locator->getHandlerForIdentity('nonExistentHook');
    }

    public function testGetHandlerForIdentityReturnsHandlerWhenFound()
    {
        $this->locator->addHandler('displayHeader', $this->handler);

        $this->assertSame($this->handler, $this->locator->getHandlerForIdentity('displayHeader'));
    }
}
