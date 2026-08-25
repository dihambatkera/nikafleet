#!/bin/bash
set -e

# ─── 1. Generate app key if not set ──────────────────────────────────────────
if [ -z "$APP_KEY" ]; then
    echo "Generating APP_KEY..."
    php artisan key:generate --force
fi

# ─── 2. Create storage symlink ────────────────────────────────────────────────
php artisan storage:link --force 2>/dev/null || true

# ─── 3. Run migrations ───────────────────────────────────────────────────────
echo "Running migrations..."
php artisan migrate --force

# ─── 4. Cache config / routes / views for production ─────────────────────────
echo "Caching application..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

# ─── 5. Ensure storage & cache dirs are writable ─────────────────────────────
chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache
chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# ─── 6. Start Supervisor (manages Nginx + PHP-FPM + Queue) ───────────────────
echo "Starting services via Supervisor..."
exec /usr/bin/supervisord -c /etc/supervisor/conf.d/supervisord.conf