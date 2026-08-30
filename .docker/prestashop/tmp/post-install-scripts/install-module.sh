#!/bin/sh
set -eu

exec runuser -g www-data -u www-data -- \
    php /usr/local/libexec/prestashop-module-hook-bus/install-module.php
