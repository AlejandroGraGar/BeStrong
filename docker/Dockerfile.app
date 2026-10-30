FROM php:8.2-fpm-alpine

# Dependencias del sistema
RUN apk add --no-cache \
    nginx \
    sqlite \
    sqlite-dev \
    libpng-dev \
    libzip-dev \
    zip \
    unzip \
    git \
    curl \
    supervisor

# Extensiones PHP
RUN docker-php-ext-install \
    pdo \
    pdo_sqlite \
    zip \
    gd \
    bcmath \
    opcache

# Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Configuraciones (rutas actualizadas a docker/conf/)
COPY docker/conf/nginx.conf         /etc/nginx/nginx.conf
COPY docker/conf/supervisord.conf   /etc/supervisor/conf.d/supervisord.conf
COPY docker/conf/php-fpm-pool.conf  /usr/local/etc/php-fpm.d/www.conf

# Script de arranque
COPY docker/entrypoint.sh /entrypoint.sh
RUN chmod +x /entrypoint.sh

WORKDIR /var/www/html

# Instalar dependencias PHP en tiempo de build (quedan en la imagen)
COPY composer.json composer.lock ./
RUN composer install --no-dev --optimize-autoloader --no-scripts --no-interaction

# Crear directorios que Laravel necesita.
# El chown se hace en el entrypoint con el UID real del host (HOST_UID/HOST_GID).
RUN mkdir -p storage/logs \
             storage/framework/cache/data \
             storage/framework/sessions \
             storage/framework/views \
             storage/app/public \
             storage/app/private \
             bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache

# Copiar logo inicial a public storage si existe en el repo
COPY storage/logo.png storage/app/public/logo.png

EXPOSE 80

ENTRYPOINT ["/entrypoint.sh"]
