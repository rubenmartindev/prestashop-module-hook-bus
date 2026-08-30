<?php

if (!defined('_PS_VERSION_')) {
    exit;
}

require_once __DIR__ . '/vendor/autoload.php';

use HookBusDemo\Hook\DisplayHomeHandler;
use RubenMartinDev\PrestashopModuleHookBus\HookBusFactory;
use RubenMartinDev\PrestashopModuleHookBus\Identifier\MethodHookIdentifier;

class HookBusDemo extends Module
{
    private $hookBus;

    public function __construct()
    {
        $this->name = 'hookbusdemo';
        $this->tab = 'front_office_features';
        $this->version = '1.0.0';
        $this->author = 'RubenMartinDev';
        $this->need_instance = 0;
        $this->bootstrap = true;

        parent::__construct();

        $this->displayName = 'Hook Bus Demo';
        $this->description = 'Development fixture for PrestaShop Module Hook Bus.';
        $this->ps_versions_compliancy = ['min' => '1.6.0.0', 'max' => _PS_VERSION_];
        $this->hookBus = HookBusFactory::createWithArray(
            new MethodHookIdentifier(),
            [new DisplayHomeHandler()]
        );
    }

    public function install()
    {
        Module::updateTranslationsAfterInstall(false);

        return parent::install() && $this->registerHook('displayHome');
    }

    public function hookDisplayHome(array $params)
    {
        return $this->hookBus->dispatch(__FUNCTION__, $params);
    }
}
