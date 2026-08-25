FROM php:8.3-fpm

# --------------------------------------------------
# System dependencies
# --------------------------------------------------

RUN apt-get update && apt-get install -y \
    git \
    curl \
    unzip \
    zip \
    nginx \
    && rm -rf /var/lib/apt/lists/*

# --------------------------------------------------
# PHP extensions via install-php-extensions (IPE)
# IPE auto-installs all required system libs and handles
# path discovery — no manual configure flags needed.
# --------------------------------------------------

ADD https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions /usr/local/bin/

RUN chmod +x /usr/local/bin/install-php-extensions \
    && install-php-extensions \
        pdo_mysql \
        gd \
        mbstring \
        exif \
        pcntl \
        bcmath \
        xml \
        zip \
        intl \
        opcache

# --------------------------------------------------
# Composer
# --------------------------------------------------

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# --------------------------------------------------
# Node.js
# --------------------------------------------------

COPY --from=node:22 /usr/local/bin/node /usr/local/bin/node
COPY --from=node:22 /usr/local/lib/node_modules /usr/local/lib/node_modules
RUN ln -s /usr/local/lib/node_modules/npm/bin/npm-cli.js /usr/local/bin/npm

# --------------------------------------------------
# Laravel
# --------------------------------------------------

WORKDIR /var/www

COPY . .

# PHP dependencies
RUN composer install \
    --no-dev \
    --optimize-autoloader \
    --no-interaction

# Frontend dependencies + build
RUN npm ci
RUN npm run build

# --------------------------------------------------
# Laravel directories
# --------------------------------------------------

RUN mkdir -p \
    storage/framework/cache \
    storage/framework/sessions \
    storage/framework/views \
    storage/logs \
    bootstrap/cache

RUN chown -R www-data:www-data \
    storage \
    bootstrap/cache

# --------------------------------------------------
# NGINX
# --------------------------------------------------

COPY docker/nginx.conf /etc/nginx/sites-available/default

EXPOSE 10000

CMD ["sh", "-c", "php-fpm -D && nginx -g 'daemon off;'"]