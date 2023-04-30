FROM php:8.0-fpm-alpine

# install configure file
RUN cp /usr/local/etc/php/php.ini-production /usr/local/etc/php/php.ini

# settings
COPY settings/php.ini /usr/local/etc/php/conf.d/php.ini

# app sources
COPY src /usr/share/nginx/html
