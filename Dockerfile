FROM php:8.4-fpm-alpine

WORKDIR /var/www/html

# System-Dependencies
RUN apk add --no-cache \
    nginx \
    supervisor \
    postgresql-dev \
    icu-dev \
    oniguruma-dev \
    libzip-dev \
    unzip \
    curl

# PHP Extensions
RUN docker-php-ext-install \
    pdo \
    pdo_pgsql \
    intl \
    zip \
    opcache

# Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Nginx Config
COPY docker/nginx.conf /etc/nginx/nginx.conf

# Supervisor Config (nginx + php-fpm zusammen)
COPY docker/supervisord.conf /etc/supervisord.conf

# App
COPY . .

RUN composer install --no-dev --optimize-autoloader --no-scripts
RUN APP_ENV=prod php bin/console cache:clear
RUN APP_ENV=prod php bin/console cache:warmup

RUN chown -R www-data:www-data /var/www/html/var

EXPOSE 80

CMD ["/usr/bin/supervisord", "-c", "/etc/supervisord.conf"]
