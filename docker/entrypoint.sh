#!/bin/sh
set -e

# Railway (and most PaaS) tell the app which port to listen on.
PORT="${PORT:-80}"
sed -i "s/^Listen .*/Listen ${PORT}/" /etc/apache2/ports.conf
sed -i "s/<VirtualHost \*:[0-9]*>/<VirtualHost *:${PORT}>/" /etc/apache2/sites-available/000-default.conf

# A freshly mounted volume is empty: put the bundled images back.
UPLOADS=/var/www/html/public/uploads
mkdir -p "$UPLOADS"
cp -an /opt/uploads-seed/. "$UPLOADS"/
chown -R www-data:www-data "$UPLOADS"

php /var/www/html/docker/init-db.php || echo "init-db: skipped (database not reachable yet)"

exec docker-php-entrypoint "$@"
