# syntax=docker/dockerfile:1

ARG PS_VERSION_TAG=9

FROM prestashop/prestashop:${PS_VERSION_TAG}

ARG HOST_UID=1000
ARG HOST_GID=1000

COPY --link --from=mlocati/php-extension-installer:2 \
    /usr/bin/install-php-extensions \
    /usr/local/bin/install-php-extensions

RUN install-php-extensions xdebug

RUN groupmod --gid "${HOST_GID}" www-data \
    && usermod --uid "${HOST_UID}" --gid "${HOST_GID}" www-data

COPY --link \
    .docker/prestashop/php/xdebug.ini \
    /usr/local/etc/php/conf.d/zz-xdebug.ini

COPY --link --chmod=755 \
    .docker/prestashop/pre-install-scripts/permissions.sh \
    /tmp/pre-install-scripts/permissions.sh
