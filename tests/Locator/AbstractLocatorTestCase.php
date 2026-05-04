<?php

namespace RubenMartinDev\PrestashopModuleHookBus\Tests\Locator;

use PHPUnit_Framework_MockObject_MockObject;
use PHPUnit\Framework\TestCase;
use RubenMartinDev\PrestashopModuleHookBus\Handler\HookHandlerInterface;

abstract class AbstractLocatorTestCase extends TestCase
{
    /**
     * @return HookHandlerInterface&PHPUnit_Framework_MockObject_MockObject
     */
    protected function createHookHandlerMock()
    {
        return $this->createMock(HookHandlerInterface::class);
    }
}
