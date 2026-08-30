#!/bin/sh
set -eu

runuser -u www-data -- composer install \
    --working-dir=/var/www/html/modules/hookbusdemo \
    --no-interaction \
    --prefer-dist
