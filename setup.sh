#!/bin/bash
php artisan migrate:fresh --seed
php artisan storage:link
php artisan optimize:clear
php artisan view:clear
php artisan config:clear
php artisan route:clear
npm run build
