# ==============================================================================
# MyLinx - PHP-FPM Development Container
# Base: Debian Bookworm (cross-platform compatible)
# ==============================================================================

FROM php:8.3-fpm-bookworm

LABEL maintainer="MyLinx Team"
LABEL description="PHP 8.3 FPM with Laravel dependencies for MyLinx SaaS"

# --------------------------------------------------------------------------
# Build arguments for host UID/GID mapping (cross-platform)
# --------------------------------------------------------------------------
ARG UID=1000
ARG GID=1000

# --------------------------------------------------------------------------
# Environment variables
# --------------------------------------------------------------------------
ENV DEBIAN_FRONTEND=noninteractive

# --------------------------------------------------------------------------
# 1. Install system dependencies
# --------------------------------------------------------------------------
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

# --------------------------------------------------------------------------
# 2. Install & configure PHP extensions
# --------------------------------------------------------------------------
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

# --------------------------------------------------------------------------
# 3. Install Composer (latest stable)
# --------------------------------------------------------------------------
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# --------------------------------------------------------------------------
# 4. Install Node.js 20 LTS & npm
# --------------------------------------------------------------------------
RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y --no-install-recommends nodejs \
    && rm -rf /var/lib/apt/lists/*

# --------------------------------------------------------------------------
# 5. Configure www-data user to match host UID/GID (prevents permission issues)
# --------------------------------------------------------------------------
RUN userdel -f www-data || true \
    && groupdel www-data 2>/dev/null || true \
    && if getent group ${GID} > /dev/null 2>&1; then groupmod -n www-data $(getent group ${GID} | cut -d: -f1); else groupadd -g ${GID} www-data; fi \
    && useradd -l -u ${UID} -g www-data -m -s /bin/bash www-data \
    && mkdir -p /var/www/html \
    && chown -R www-data:www-data /var/www/html

# --------------------------------------------------------------------------
# 6. Custom PHP configuration for development
# --------------------------------------------------------------------------
RUN mv "$PHP_INI_DIR/php.ini-development" "$PHP_INI_DIR/php.ini"

# --------------------------------------------------------------------------
# 7. Set working directory
# --------------------------------------------------------------------------
WORKDIR /var/www/html

EXPOSE 9000

CMD ["php-fpm"]
