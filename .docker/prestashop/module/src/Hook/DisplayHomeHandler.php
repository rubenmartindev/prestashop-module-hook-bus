<?php

namespace HookBusDemo\Hook;

use RubenMartinDev\PrestashopModuleHookBus\Handler\NamedHandlerInterface;

final class DisplayHomeHandler implements NamedHandlerInterface
{
    public static function getIdentityName()
    {
        return 'displayHome';
    }

    public function handle(array $params = [])
    {
        return '<div id="hookbus-demo">Hook Bus fixture is active.</div>';
    }
}
