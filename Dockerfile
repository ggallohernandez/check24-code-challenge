FROM php:8-fpm
ENV XDEBUG_REMOTE_HOST localhost

RUN apt-get update \
    && apt-get install -yq vim git software-properties-common python3-software-properties wget gnupg libzip-dev zip unzip \
    && apt-get -y autoremove \
    && rm -rf /var/lib/apt/lists

RUN pecl install xdebug-3.0.1 \
    && docker-php-ext-enable xdebug \
    && docker-php-ext-install pdo \
    && docker-php-ext-enable pdo \
    && docker-php-ext-install pdo_mysql \
    && docker-php-ext-enable pdo_mysql \
    && docker-php-ext-install zip \
    && docker-php-ext-enable zip

COPY .docker/php-fpm/xdebug.ini /usr/local/etc/php/conf.d/xdebug.ini
COPY .docker/php-fpm/php.ini /usr/local/etc/php/

COPY .docker/php-fpm/install_composer.sh /usr/local/bin/install_composer.sh
RUN chmod +x /usr/local/bin/install_composer.sh
RUN sed -i -re "s/\r$//" /usr/local/bin/install_composer.sh

RUN install_composer.sh

RUN adduser --disabled-password --gecos "" --shell /bin/false app

USER app
WORKDIR /app

EXPOSE 9000
CMD ["php-fpm"]