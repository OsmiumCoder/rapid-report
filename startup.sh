cd /app

php artisan migrate --force
php artisan db:seed --class=RolesAndPermissionsSeeder --force

/usr/bin/supervisord -c /etc/supervisor/conf.d/supervisord.conf
