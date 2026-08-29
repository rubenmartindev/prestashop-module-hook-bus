# syntax=docker/dockerfile:1

ARG PS_VERSION=9

FROM prestashop/prestashop:${PS_VERSION}

ARG HOST_UID=1000
ARG HOST_GID=1000

RUN groupmod --gid "${HOST_GID}" www-data \
    && usermod --uid "${HOST_UID}" --gid "${HOST_GID}" www-data

COPY --link --chmod=755 \
    .docker/prestashop/pre-install-scripts/permissions.sh \
    /tmp/pre-install-scripts/permissions.sh
