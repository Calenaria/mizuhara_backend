#!/bin/sh
set -e

echo "Installing assets..."
APP_ENV=dev php bin/console assets:install

echo "Warming up cache..."
APP_ENV=dev php bin/console cache:warmup

echo "Running migrations..."
APP_ENV=dev php bin/console doctrine:migrations:migrate --no-interaction

exec /usr/bin/supervisord -c /etc/supervisord.conf
