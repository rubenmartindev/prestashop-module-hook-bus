<?php

namespace RubenMartinDev\PrestashopModuleHookBus\Tests\Identifier;

use PHPUnit\Framework\TestCase;
use RubenMartinDev\PrestashopModuleHookBus\Identifier\LiteralIdentifier;

class LiteralIdentifierTest extends TestCase
{
    public function testIdentify()
    {
        $identifer = new LiteralIdentifier();

        $this->assertSame('displayHeader', $identifer->identify('displayHeader'));
    }
}
