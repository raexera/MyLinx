FROM php:8.3-fpm-bookworm

LABEL maintainer="MyLinx Team"
LABEL description="PHP 8.3 FPM with Laravel dependencies for MyLinx SaaS"

ARG UID=1000
ARG GID=1000

ENV DEBIAN_FRONTEND=noninteractive

RUN apt-get update && apt-get install -y --no-install-recommends \
    git \
    curl \
    unzip \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    libpq-dev \
    libzip-dev \
    libicu-dev \
    libonig-dev \
    && rm -rf /var/lib/apt/lists/*

RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) \
        pdo_pgsql \
        pgsql \
        gd \
        zip \
        intl \
        bcmath \
        opcache \
        mbstring \
        exif

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y --no-install-recommends nodejs \
    && rm -rf /var/lib/apt/lists/*

RUN userdel -f www-data || true \
    && groupdel www-data 2>/dev/null || true \
    && if getent group ${GID} > /dev/null 2>&1; then groupmod -n www-data $(getent group ${GID} | cut -d: -f1); else groupadd -g ${GID} www-data; fi \
    && useradd -l -u ${UID} -g www-data -m -s /bin/bash www-data \
    && mkdir -p /var/www/html \
    && chown -R www-data:www-data /var/www/html

RUN mv "$PHP_INI_DIR/php.ini-development" "$PHP_INI_DIR/php.ini"

WORKDIR /var/www/html

EXPOSE 9000

CMD ["php-fpm"]
