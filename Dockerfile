FROM signnow/php:7.3-alpine-1.2.0

ARG BUILD_ID=0
ARG VERSION=0.0.1

ENV BUILD_ID=${BUILD_ID} \
    APPLICATION_VERSION=${VERSION} \
    DEBIAN_FRONTEND=noninteractive

LABEL build_id="${BUILD_ID}" \
    version="${VERSION}" \
    description="Jerk Docker Image"

COPY . /var/www

RUN cp -R /var/www/docker/nginx/* /etc/nginx/ \
    && cp /var/www/docker/php/app.ini /etc/php7/conf.d/app.ini \
    && cp -R /var/www/docker/provision/entrypoint.d/* /entrypoint.d \
    && ln -s /etc/php7/conf.d/app.ini /etc/php7/php-fpm.d/app.ini

RUN /usr/bin/crontab /var/www/docker/cron/root

RUN bash /var/www/docker/provision/after-build.sh

EXPOSE 80

WORKDIR /var/www
