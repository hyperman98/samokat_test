FROM php:8.2-fpm

RUN apt-get update && apt-get install -y \
        libicu-dev \
        libzip-dev \
        libpq-dev \
        libc-client-dev\
        libkrb5-dev\
    && docker-php-ext-install -j$(nproc) intl \
    && docker-php-ext-install -j$(nproc) pgsql \
    && docker-php-ext-install -j$(nproc) pdo_pgsql \
    && docker-php-ext-install -j$(nproc) zip \
    && docker-php-ext-install sockets

# Install Composer
COPY --from=composer:2.5.8 /usr/bin/composer /usr/local/bin/composer

WORKDIR /srv

CMD ["php-fpm"]
