# =============================================================================
# MyLinx - PHP-FPM Application Container
# =============================================================================
FROM php:8.3-fpm-alpine AS base

ARG UID=1000
ARG GID=1000

# ---- System dependencies & PHP extensions -----------------------------------
RUN apk add --no-cache \
        bash \
        curl \
        git \
        unzip \
        shadow \
        icu-dev \
        libpng-dev \
        libjpeg-turbo-dev \
        freetype-dev \
        libzip-dev \
        libxml2-dev \
        postgresql-dev \
        oniguruma-dev \
        linux-headers \
        nodejs \
        npm \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j"$(nproc)" \
        pdo \
        pdo_pgsql \
        pgsql \
        gd \
        zip \
        bcmath \
        intl \
        opcache \
        mbstring \
        exif \
        pcntl \
        xml \
    && rm -rf /var/cache/apk/*

# ---- OPcache defaults (dev-friendly) ----------------------------------------
RUN { \
    echo 'opcache.memory_consumption=128'; \
    echo 'opcache.interned_strings_buffer=8'; \
    echo 'opcache.max_accelerated_files=4000'; \
    echo 'opcache.revalidate_freq=0'; \
    echo 'opcache.validate_timestamps=1'; \
    echo 'opcache.fast_shutdown=1'; \
    } > /usr/local/etc/php/conf.d/opcache-recommended.ini

# ---- PHP configuration overrides --------------------------------------------
RUN { \
    echo 'upload_max_filesize=64M'; \
    echo 'post_max_size=64M'; \
    echo 'memory_limit=256M'; \
    echo 'max_execution_time=60'; \
    } > /usr/local/etc/php/conf.d/custom.ini

# ---- Composer ----------------------------------------------------------------
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# ---- Create non-root user matching host UID/GID -----------------------------
RUN deluser --remove-home www-data 2>/dev/null || true \
    && delgroup www-data 2>/dev/null || true \
    && addgroup -g ${GID} www-data \
    && adduser -u ${UID} -G www-data -D -s /bin/bash www-data

WORKDIR /var/www/html

RUN mkdir -p \
        storage/framework/sessions \
        storage/framework/views \
        storage/framework/cache \
        storage/logs \
        bootstrap/cache \
    && chown -R www-data:www-data /var/www/html

USER www-data

EXPOSE 9000
CMD ["php-fpm"]
