#!/bin/sh
set -e

echo "🚀 Preparando entorno BeStrong..."

# Detectar el UID/GID del host leyendo el propietario de los ficheros del bind mount.
# Así funciona en cualquier máquina sin necesidad de variables de entorno externas.
UID_VAL=$(stat -c '%u' /var/www/html/artisan 2>/dev/null || echo "1000")
GID_VAL=$(stat -c '%g' /var/www/html/artisan 2>/dev/null || echo "1000")

# Crear .env si no existe aún y asegurar pertenencia al usuario del host
if [ ! -f .env ]; then
    echo "📄 Creando .env desde .env.example..."
    cp .env.example .env
fi
chown "${UID_VAL}:${GID_VAL}" .env 2>/dev/null || true
chmod 664 .env 2>/dev/null || true

# Generar APP_KEY si está vacía
if grep -q "^APP_KEY=$" .env; then
    echo "🔑 Generando APP_KEY..."
    php artisan key:generate
fi

# Crear base de datos SQLite si no existe
if [ ! -f database/database.sqlite ]; then
    echo "🗄️  Creando base de datos SQLite..."
    touch database/database.sqlite
fi
chown "${UID_VAL}:${GID_VAL}" database/database.sqlite 2>/dev/null || true
chmod 664 database/database.sqlite 2>/dev/null || true

# Crear directorios necesarios para Laravel (por si acaso no existen en el volumen)
mkdir -p storage/logs \
         storage/framework/cache/data \
         storage/framework/sessions \
         storage/framework/views \
         storage/app/public \
         storage/app/private \
         bootstrap/cache

# Ajustar PHP-FPM para correr como el usuario del host.
# Así PHP-FPM tiene el mismo UID que los ficheros del bind mount → sin conflictos de permisos.
sed -i "s/^user = .*/user = ${UID_VAL}/"  /usr/local/etc/php-fpm.d/www.conf
sed -i "s/^group = .*/group = ${GID_VAL}/" /usr/local/etc/php-fpm.d/www.conf

# Fijar ownership de los volúmenes nombrados (storage, bootstrap/cache, vendor)
# al usuario del host. Estos son volúmenes Docker, no ficheros del host → seguro.
chown -R "${UID_VAL}:${GID_VAL}" storage bootstrap/cache vendor

echo "🗄️  Ejecutando migraciones..."
php artisan migrate --force

# Asegurar enlace simbólico de almacenamiento público
php artisan storage:link 2>/dev/null || true
chown -h "${UID_VAL}:${GID_VAL}" public/storage 2>/dev/null || true

# Si se pasaron comandos al contenedor, ejecutarlos en lugar de arrancar supervisord
if [ "$#" -gt 0 ]; then
    exec "$@"
fi

echo "✅ Entorno listo. Arrancando servicios..."

# Iniciar Nginx + PHP-FPM via Supervisor
exec /usr/bin/supervisord -c /etc/supervisor/conf.d/supervisord.conf
