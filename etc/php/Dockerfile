FROM php:7.3.6-fpm-alpine
WORKDIR /app

RUN apk --update upgrade \
    && apk add --no-cache autoconf automake make gcc g++ icu-dev \
    && pecl install \
        apcu-5.1.17 \
        redis-5.1.1 \
    && docker-php-ext-install -j$(nproc) \
        bcmath \
        opcache \
        intl \
    && docker-php-ext-enable \
        apcu \
        opcache \
        redis