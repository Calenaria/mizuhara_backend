#!/bin/sh
set -e

echo "Warming up cache..."
APP_ENV=prod php bin/console cache:warmup

echo "Running migrations..."
APP_ENV=prod php bin/console doctrine:migrations:migrate --no-interaction

exec /usr/bin/supervisord -c /etc/supervisord.conf
