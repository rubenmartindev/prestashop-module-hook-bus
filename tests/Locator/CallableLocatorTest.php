<?php

namespace RubenMartinDev\PrestashopModuleHookBus\Tests\Locator;

use RubenMartinDev\PrestashopModuleHookBus\Locator\CallableLocator;
use RubenMartinDev\PrestashopModuleHookBus\Locator\Exception\MissingHandlerException;
use RubenMartinWebhook\Hook\Handler\HookHandlerInterface;

class CallableLocatorTest extends AbstractLocatorTestCase
{
    /** @var CallableLocator */
    private $locator;

    /** @var HookHandlerInterface */
    private $handler;

    protected function setUp()
    {
        parent::setUp();

        $this->handler = $this->createHookHandlerMock();

        $this->locator = new CallableLocator(function ($hookName) {
            if ('displayHeader' === $hookName) {
                return $this->handler;
            }
        });
    }

    public function testGetHandlerForIdentifyThrowsExceptionWhenNotFound()
    {
        $this->expectException(MissingHandlerException::class);

        $this->locator->getHandlerForIdentity('nonExistentIdentity');
    }

    public function testGetHandlerForIdentifyReturnsHandlerWhenFound()
    {
        $this->assertSame($this->handler, $this->locator->getHandlerForIdentity('displayHeader'));
    }
}
