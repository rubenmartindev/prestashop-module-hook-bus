<?php

require_once '/var/www/html/config/config.inc.php';

$module = Module::getInstanceByName('hookbusdemo');

if (!$module || Module::isInstalled('hookbusdemo')) {
    exit(0);
}

Module::updateTranslationsAfterInstall(false);

if (!$module->install()) {
    fwrite(STDERR, "Unable to install hookbusdemo module.\n");
    exit(1);
}
