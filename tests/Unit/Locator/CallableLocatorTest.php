<?php

namespace RubenMartinDev\PrestashopModuleHookBus\Tests\Unit\Locator;

use RubenMartinDev\PrestashopModuleHookBus\Locator\CallableLocator;
use RubenMartinDev\PrestashopModuleHookBus\Locator\Exception\MissingHandlerException;
use RubenMartinWebhook\Hook\Handler\HookHandlerInterface;

class CallableLocatorTest extends AbstractLocatorTestCase
{
    /** @var CallableLocator */
    private $locator;

    /** @var HookHandlerInterface */
    private $handler;

    public function setUp()
    {
        parent::setUp();

        $this->handler = $this->createHookHandlerMock();

        $this->locator = new CallableLocator(function ($hookName) {
            if ('displayHeader' === $hookName) {
                return $this->handler;
            }
        });
    }

    public function testGetHandlerForHookThrowsExceptionWhenNotFound()
    {
        $this->expectException(MissingHandlerException::class);

        $this->locator->getHandlerForHook('nonExistentHook');
    }

    public function testGetHandlerForHookReturnsHookHandlerWhenFound()
    {
        $this->assertSame($this->handler, $this->locator->getHandlerForHook('displayHeader'));
    }
}
