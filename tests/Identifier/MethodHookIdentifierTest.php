<?php

namespace RubenMartinDev\PrestashopModuleHookBus\Tests\Identifier;

use PHPUnit\Framework\TestCase;
use RubenMartinDev\PrestashopModuleHookBus\Identifier\Exception\UnresolvedHookIdentifierException;
use RubenMartinDev\PrestashopModuleHookBus\Identifier\MethodHookIdentifier;

class MethodHookIdentifierTest extends TestCase
{
    /** @var MethodHookIdentifier */
    private $identifier;

    protected function setUp()
    {
        parent::setUp();

        $this->identifier = new MethodHookIdentifier();
    }

    public function testIdentifyThrowsExceptionWhenMethodIsInvalid()
    {
        $this->expectException(UnresolvedHookIdentifierException::class);

        $this->identifier->identify('displayHeader');
    }

    public function testIdentifyReturnsIdentifyWheMethodIsValid()
    {
        $this->assertSame('displayHeader', $this->identifier->identify('hookDisplayHeader'));
    }
}
