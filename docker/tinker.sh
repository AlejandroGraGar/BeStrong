#!/bin/bash
set -e

# Comprobar que el contenedor está en ejecución
if ! docker ps --format '{{.Names}}' | grep -q '^bestrong_app$'; then
    echo "⚠️  El contenedor bestrong_app no está en ejecución."
    echo "Arráncalo primero con:"
    echo "   cd $(dirname "$0") && docker compose up -d"
    exit 1
fi

# Abrir directamente la consola interactiva de Laravel
docker exec -it bestrong_app php artisan tinker "$@"
