<?php

namespace RubenMartinDev\PrestashopModuleHookBus\Tests\Unit\Identifier;

use PHPUnit\Framework\TestCase;
use RubenMartinDev\PrestashopModuleHookBus\Identifier\CallableIdentifier;
use RubenMartinDev\PrestashopModuleHookBus\Identifier\Exception\UnresolvedHookIdentifierException;
use RubenMartinDev\PrestashopModuleHookBus\Identifier\HookIdentifierInterface;

class CallableIdentifierTest extends TestCase
{
    /** @var HookIdentifierInterface */
    private $identifier;

    protected function setUp()
    {
        parent::setUp();

        $this->identifier = new CallableIdentifier(function ($hookName) {
            if ('hookIdentity' === $hookName) {
                return 'displayHeader';
            }
        });
    }

    public function testIdentifyThrowsExceptionWhenNotFound()
    {
        $this->expectException(UnresolvedHookIdentifierException::class);

        $this->identifier->identify('nonExistentIdentity');
    }

    public function testIdentifyReturnsIdentityWhenFound()
    {
        $this->assertSame('displayHeader', $this->identifier->identify('hookIdentity'));
    }
}
