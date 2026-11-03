# BeStrong

Aplicación web para gestión y registro de entrenamientos, rutinas y ejercicios (Proyecto TFG).

---

## 🚀 Puesta en marcha rápida (Docker)

No necesitas instalar PHP, Composer, Node ni servidores en tu equipo local. Todo se ejecuta de manera aislada mediante contenedores Docker.

### 1. Clonar y arrancar

```bash
git clone git@github.com:AlejandroGraGar/BeStrong.git
cd BeStrong
bash setup.sh
```

El script `setup.sh` es inteligente y se encarga automáticamente de:
- Detectar si las imágenes o contenedores existen, compilándolos solo si faltan.
- Configurar permisos automáticamente con tu usuario local del host.
- Crear el `.env` y la base de datos SQLite con sus migraciones.
- Conectar el almacenamiento público para fotos y logos (`storage:link`).
- Descargar e importar el catálogo inicial (>600 ejercicios desde wger.de).

### 2. Acceso a la aplicación

- **Web:** [http://localhost](http://localhost) (puerto 80)
- **Vite (HMR):** [http://localhost:5173](http://localhost:5173)

---

## 🛠️ Comandos de gestión (`setup.sh`)

Puedes controlar todo el entorno directamente desde la raíz del proyecto usando `setup.sh`:

### `bash setup.sh start` (o simplemente `bash setup.sh`)
* **Qué hace:** Arranca los contenedores. Si ya están construidos, inicia en 1-2 segundos. Si falta alguna imagen o se detuvo algún contenedor, lo detecta y lo levanta automáticamente. Si todo está ya en marcha, te pregunta directamente si deseas reiniciar.
* **Cuándo usarlo:** En tu día a día para encender el entorno de trabajo.
* **Por qué:** Es la forma más rápida y segura de empezar a programar sin recompilaciones innecesarias.

### `bash setup.sh status`
* **Qué hace:** Muestra una radiografía completa en tiempo real: estado de los contenedores, conectividad HTTP (puertos 80 y 5173), tamaño de la base de datos SQLite, imágenes disponibles, volúmenes creados y archivos de log en el host.
* **Cuándo usarlo:** Cuando quieras verificar la salud del entorno o diagnosticar por qué no carga la web.
* **Por qué:** Te ofrece una visión integral del sistema en un solo comando sin tener que consultar `docker ps` o inspeccionar puertos a mano.

### `bash setup.sh stop`
* **Qué hace:** Detiene los contenedores de forma ordenada.
* **Cuándo usarlo:** Al finalizar tu jornada de trabajo o cuando quieras liberar memoria RAM y CPU en tu ordenador.
* **Por qué:** Es seguro; no borra ningún dato. Tus usuarios, ejercicios, rutinas y dependencias quedan intactos en disco para la próxima vez que ejecutes `start`.

### `bash setup.sh restart`
* **Qué hace:** Reinicia los contenedores y espera 2 segundos para comprobar que los servicios vuelven a responder.
* **Cuándo usarlo:** Si has realizado cambios en variables del fichero `.env` o en la configuración interna de Nginx/PHP.
* **Por qué:** Aplica cambios de configuración rápidamente sin tener que parar y arrancar manualmente.

### `bash setup.sh logs [app|vite]`
* **Qué hace:** Muestra y sigue en tiempo real las salidas y trazas de error de los servicios.
* **Cuándo usarlo:** Cuando la web devuelva un error 500, una migración falle o quieras depurar la recarga en caliente de Vite.
* **Por qué:** Te permite ver al instante qué está ocurriendo internamente mientras navegas por la aplicación.

### `bash setup.sh clean`
* **Qué hace:** Elimina de golpe todo el entorno Docker (todos los contenedores, todas las imágenes y los volúmenes de Docker `app_vendor`, `app_storage`, `vite_node_modules`, etc.). **Conserva intactos la base de datos SQLite y el fichero `.env` en tu host**.
* **Cuándo usarlo:** Cuando quieras retirar y purgar por completo el entorno Docker para liberar todo el espacio en disco, pero sin perder tus usuarios ni tus rutinas guardadas.
* **Por qué:** Es la contrapartida natural de `start`: mientras `start` descarga, construye y arranca el entorno, `clean` lo desmantela y limpia por completo (contenedores, volúmenes e imágenes) en un solo comando.

### `bash setup.sh rmi <app|vite|all>`
* **Qué hace:** Elimina la imagen Docker indicada (`app` o `vite`) o ambas con `all`, deteniendo previamente el contenedor asociado. Si se ejecuta sin parámetros, muestra su ayuda de uso. **No toca la base de datos SQLite ni el `.env`**.
* **Cuándo usarlo:** Si una imagen concreta se ha corrompido o deseas que `start` la vuelva a construir desde cero.
* **Por qué:** Evita errores de conflicto en Docker al detener y retirar automáticamente el contenedor antes de borrar la imagen.

### `bash setup.sh rmv <vendor|storage|cache|node_modules|all>`
* **Qué hace:** Elimina el volumen Docker específico indicado (`vendor`, `storage`, `cache` o `node_modules`), o los 4 volúmenes juntos con `all`. Detiene previamente el contenedor asociado para evitar bloqueos. **No toca la base de datos SQLite ni el `.env`**.
* **Cuándo usarlo:** Cuando quieras purgar la caché de Laravel (`cache`), limpiar dependencias de Composer (`vendor`) o de Vite (`node_modules`) para forzar que se regeneren limpias.
* **Por qué:** Ofrece control granular sobre los volúmenes de Docker sin tener que borrar todo el proyecto ni recurrir a comandos manuales de `docker volume rm`.

### `bash setup.sh help` (o `-h`)
* **Qué hace:** Muestra la ayuda interactiva en terminal con la lista completa de comandos y opciones adicionales.
* **Cuándo usarlo:** Cuando quieras recordar rápidamente la sintaxis de algún parámetro sin consultar el README.

---

## ⚖️ Recompilar vs Reinstalar: `build` vs `reset`

Es muy importante distinguir entre estas dos opciones para evitar pérdidas accidentales de datos:

### `bash setup.sh build` (o `bash setup.sh start --build`)
* **Qué hace:** Recompila las imágenes de Docker (`Dockerfile.app` y `Dockerfile.vite`) aplicando cambios de dependencias. **No borra la base de datos ni el fichero `.env`**.
* **Cuándo usarlo:** Cuando instales o actualices paquetes en `composer.json` o `package.json`, o cuando modifiques dependencias del sistema en los Dockerfiles.
* **Por qué:** Quieres actualizar el software base del contenedor pero **conservando intactos** tus usuarios de prueba, historial de entrenamientos y datos de la base de datos.

### `bash setup.sh reset [-y|--yes]` (Restablecimiento total - DESTRUCTIVO)
* **Qué hace:** Elimina contenedores, imágenes Docker, volúmenes de almacenamiento, el archivo `.env` y el fichero `database/database.sqlite`. Tras ello, reconstruye todo desde cero y vuelve a importar los ejercicios iniciales. Solicita confirmación interactiva `[s/N]` previa, salvo que se añada el flag `-y` o `--yes` (útil para automatización y CI).
* **Cuándo usarlo:** Cuando quieras simular la experiencia exacta de un nuevo desarrollador que clona el repositorio por primera vez, o si la base de datos local ha quedado en un estado corrupto o inconsistente.
* **Por qué:** Porque necesitas un "borrón y cuenta nueva" total donde ningún dato previo interfiera.

---

## 💻 Consola interactiva (Laravel Tinker)

Para interactuar con los modelos Eloquent y ejecutar código PHP dentro del contenedor:

```bash
cd docker && ./tinker.sh
```

---

## 📁 Estructura de la carpeta `docker/`

Todo lo relativo a la infraestructura Docker reside apartado en su propio directorio:

```
docker/
├── Dockerfile.app       # Imagen PHP 8.2-FPM + Nginx + Supervisor
├── Dockerfile.vite      # Imagen Node 22 para Vite (recarga en caliente de assets)
├── docker-compose.yml   # Orquestación de servicios, redes y volúmenes
├── entrypoint.sh        # Script de inicialización (detección de UID/GID y migraciones)
├── tinker.sh            # Acceso directo a php artisan tinker
├── conf/
│   ├── nginx.conf          # Configuración del servidor web Nginx
│   ├── php-fpm-pool.conf   # Pool de PHP-FPM con usuario host dinámico
│   └── supervisord.conf    # Gestor de procesos interno
└── logs/                # Archivos de logs accesibles directamente desde el host
    ├── nginx/              # access.log y error.log de Nginx
    ├── laravel/            # laravel.log de la aplicación
    └── supervisor/         # supervisord.log del gestor de procesos
```
