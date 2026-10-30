# BeStrong

Aplicación web para gestión y registro de entrenamientos, rutinas y ejercicios (Proyecto TFG).

---

## 🚀 Puesta en marcha rápida (Docker)

No necesitas instalar PHP, Composer, Node ni servidores en tu equipo local. Todo se ejecuta aislado mediante contenedores Docker.

### 1. Clonar y arrancar por primera vez

```bash
git clone git@github.com:AlejandroGraGar/BeStrong.git
cd BeStrong
bash setup.sh
```

El script `setup.sh` se encarga de:
- Construir las imágenes (`bestrong-app` y `bestrong-vite`).
- Configurar permisos automáticamente con tu usuario local.
- Crear el `.env` y la base de datos SQLite con sus migraciones.
- Conectar el almacenamiento público para fotos y logos (`storage:link`).
- Descargar e importar el catálogo de ejercicios inicial (>600 ejercicios).

### 2. Acceso a la aplicación

- **Web:** [http://localhost](http://localhost) (puerto 80)
- **Vite (HMR):** [http://localhost:5173](http://localhost:5173)

---

## 🛠️ Comandos habituales

Una vez creado el entorno, puedes controlarlo situándote en la carpeta `docker/`:

```bash
cd docker/

# Arrancar en segundo plano
docker compose up -d

# Ver logs en tiempo real
docker compose logs -f

# Detener los contenedores
docker compose down

# Reconstruir imágenes si cambian paquetes en composer.json o package.json
docker compose up --build -d

# Consola interactiva de Laravel (Tinker)
docker compose exec app php artisan tinker
```

---

## 🔄 Reinicio completo desde cero

Si deseas restablecer la base de datos, imágenes y volúmenes para volver a tener una instalación limpia desde cero:

```bash
bash setup.sh --reset
```

---

## 📁 Estructura de la carpeta `docker/`

Todo lo relacionado con Docker se encuentra apartado en su propio directorio para no mezclar configuraciones con el código fuente de la aplicación:

```
docker/
├── Dockerfile.app       # Imagen PHP 8.2-FPM + Nginx + Supervisor
├── Dockerfile.vite      # Imagen Node 22 para Vite (recarga en caliente de assets)
├── docker-compose.yml   # Orquestación de servicios, redes y volúmenes
├── entrypoint.sh        # Script de inicialización (detección de UID/GID y migraciones)
└── conf/
    ├── nginx.conf          # Configuración del servidor web Nginx
    ├── php-fpm-pool.conf   # Pool de PHP-FPM configurado con el usuario del host
    └── supervisord.conf    # Gestor de procesos interno
```
