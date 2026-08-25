FROM php:8.3-fpm

# --------------------------------------------------
# System dependencies
# --------------------------------------------------

RUN apt-get update && apt-get install -y \
    git curl unzip zip nginx \
    && rm -rf /var/lib/apt/lists/*

# --------------------------------------------------
# PHP extensions via install-php-extensions (IPE)
# --------------------------------------------------

ADD https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions /usr/local/bin/

RUN chmod +x /usr/local/bin/install-php-extensions \
    && install-php-extensions \
        pdo_pgsql \
        gd \
        mbstring \
        exif \
        pcntl \
        bcmath \
        xml \
        zip \
        intl \
        opcache

# Verify pdo_pgsql is actually loaded – build fails here if not
RUN php -m | grep -q pdo_pgsql || (echo "❌ pdo_pgsql extension NOT found!" && exit 1)

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
# App
# --------------------------------------------------

WORKDIR /var/www

# ⚠️ DEBUG – revert to production/false when stable
ENV APP_DEBUG=true
ENV APP_ENV=local
ENV LOG_CHANNEL=stderr
ENV LOG_LEVEL=debug
# Baked-in driver – overridden by Render env vars at runtime
ENV DB_CONNECTION=pgsql

COPY . .

RUN composer install --no-dev --optimize-autoloader --no-interaction

RUN npm ci && npm run build

RUN mkdir -p \
    storage/framework/cache \
    storage/framework/sessions \
    storage/framework/views \
    storage/logs \
    bootstrap/cache \
    && chown -R www-data:www-data storage bootstrap/cache

# --------------------------------------------------
# Nginx
# --------------------------------------------------

COPY docker/nginx.conf /etc/nginx/sites-available/default

EXPOSE 10000

CMD ["sh", "-c", "php artisan migrate --force && php artisan db:seed --class=ProductionDataSeeder --force && php artisan config:cache && php artisan route:cache && php artisan view:cache && php artisan storage:link --force && php-fpm -D && nginx -g 'daemon off;'"]