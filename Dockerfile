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

ENV APP_DEBUG=false
ENV APP_ENV=production
ENV LOG_CHANNEL=stderr
ENV LOG_LEVEL=info
# Baked-in driver – overridden by Render env vars at runtime
ENV DB_CONNECTION=pgsql

COPY . .

RUN rm -f public/hot

RUN composer install --no-dev --optimize-autoloader --no-interaction

RUN npm ci && npm run build

# Configure PHP upload and memory limits
RUN echo "upload_max_filesize = 20M\npost_max_size = 64M\nmemory_limit = 256M\nmax_file_uploads = 20" > /usr/local/etc/php/conf.d/uploads.ini

RUN mkdir -p \
    storage/app/public/cars \
    storage/app/public/temp_uploads \
    storage/app/livewire-tmp \
    storage/framework/cache \
    storage/framework/sessions \
    storage/framework/views \
    storage/logs \
    bootstrap/cache \
    && chown -R www-data:www-data storage bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache

# --------------------------------------------------
# Nginx
# --------------------------------------------------

COPY docker/nginx.conf /etc/nginx/sites-available/default

EXPOSE 10000

CMD ["sh", "-c", "php artisan migrate --force && php artisan --force && php artisan config:cache && php artisan route:cache && php artisan view:cache && php artisan storage:link --force && php-fpm -D && nginx -g 'daemon off;'"]
