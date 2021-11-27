FROM php:8.0-fpm as base

RUN apt update --no-install-recommends && apt install -y \
    git \
    openssh-client \
    libzip-dev \
    zip \
    libzip-dev \
    libjpeg62-turbo-dev \
    libpng-dev \
    unzip && \
    rm -r /var/lib/apt/lists/*

RUN docker-php-ext-configure opcache --enable-opcache && \
    docker-php-ext-install pdo_mysql opcache && \
    docker-php-ext-enable opcache && \
    docker-php-ext-install zip && \
    docker-php-ext-configure zip && \
    docker-php-ext-install gd

WORKDIR /src

COPY docker/php-fpm/php.ini $PHP_INI_DIR/conf.d/php.ini

COPY composer.json composer.lock ./

COPY public/img /src/public/img

ARG GITHUB_API_TOKEN
ENV PATH="$PATH:/src/vendor/bin"
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer
COPY composer.* ./
RUN composer config -g github-oauth.github.com $GITHUB_API_TOKEN && \
    composer install --no-scripts --no-autoloader --no-interaction --no-dev

FROM base as prod
COPY . ./
RUN chgrp -R www-data storage bootstrap/cache && chmod -R ug+rwx storage bootstrap/cache && \
    composer dump-autoload --optimize

FROM base as dev
COPY . ./
RUN chgrp -R www-data storage bootstrap/cache && chmod -R ug+rwx storage bootstrap/cache && \
    composer install --no-scripts --no-autoloader --no-interaction --dev && \
    composer dump-autoload --optimize
