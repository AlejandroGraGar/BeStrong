#!/bin/bash
set -e

# ─────────────────────────────────────────────
#  BeStrong – Script de gestión del entorno Docker
#  Uso: bash setup.sh [comando|opción]
# ─────────────────────────────────────────────

BLUE='\033[0;34m'
GREEN='\033[0;32m'
RED='\033[0;31m'
YELLOW='\033[1;33m'
CYAN='\033[0;36m'
NC='\033[0m'

SCRIPT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)"
cd "$SCRIPT_DIR"

print_banner() {
    echo -e "${BLUE}"
    echo "  ██████╗ ███████╗███████╗████████╗██████╗  ██████╗ ███╗   ██╗ ██████╗ "
    echo "  ██╔══██╗██╔════╝██╔════╝╚══██╔══╝██╔══██╗██╔═══██╗████╗  ██║██╔════╝ "
    echo "  ██████╔╝█████╗  ███████╗   ██║   ██████╔╝██║   ██║██╔██╗ ██║██║  ███╗"
    echo "  ██╔══██╗██╔══╝  ╚════██║   ██║   ██╔══██╗██║   ██║██║╚██╗██║██║   ██║"
    echo "  ██████╔╝███████╗███████║   ██║   ██║  ██║╚██████╔╝██║ ╚████║╚██████╔╝"
    echo "  ╚═════╝ ╚══════╝╚══════╝   ╚═╝   ╚═╝  ╚═╝ ╚═════╝ ╚═╝  ╚═══╝ ╚═════╝ "
    echo -e "${NC}"
    echo -e "${BLUE}  Gestión del entorno de desarrollo (Docker)${NC}"
    echo ""
}

print_help() {
    print_banner
    echo -e "Uso: ${YELLOW}bash setup.sh [comando|opción]${NC}"
    echo ""
    echo "Comandos disponibles:"
    echo -e "  ${GREEN}start${NC}           Arranca los contenedores (comportamiento por defecto)."
    echo -e "                  Si ya están levantados, pregunta si deseas reiniciarlos."
    echo -e "                  Si ya están construidos, inicia de inmediato sin recompilar."
    echo -e "  ${GREEN}stop${NC}            Detiene los contenedores sin borrar datos ni volúmenes."
    echo -e "  ${GREEN}restart${NC}         Reinicia los contenedores (app y vite)."
    echo -e "  ${GREEN}status${NC}          Muestra el estado de contenedores, puertos, BD, imágenes, volúmenes y logs."
    echo -e "  ${GREEN}logs${NC}            Muestra y sigue los logs en tiempo real (admite 'app' o 'vite')."
    echo -e "  ${GREEN}build${NC}           Reconstruye las imágenes Docker sin tocar la BD ni el .env."
    echo -e "  ${GREEN}clean${NC}           Elimina todo el entorno Docker (contenedores, volúmenes e imágenes) de golpe."
    echo -e "  ${GREEN}rmi <app|vite|all>${NC} Elimina la imagen Docker indicada (o ambas con 'all')."
    echo -e "  ${GREEN}rmv <vendor|storage|cache|node_modules|all>${NC} Elimina el volumen Docker indicado (o todos)."
    echo -e "  ${GREEN}reset${NC}           ${RED}DESTRUCTIVO:${NC} Borra BD, volúmenes, imágenes y reconstruye todo."
    echo -e "  ${GREEN}help, -h${NC}        Muestra esta ayuda."
    echo ""
    echo "Opciones adicionales:"
    echo -e "  ${YELLOW}--build${NC}         Fuerza la reconstrucción de imágenes al arrancar."
    echo -e "  ${YELLOW}--reset${NC}         Equivalente al comando 'reset'."
    echo -e "  ${YELLOW}-y, --yes${NC}       Omite confirmaciones interactivas (útil en scripts/CI)."
    echo ""
}

check_prerequisites() {
    if ! command -v docker &> /dev/null; then
        echo -e "${RED}✗ Docker no está instalado. Instálalo desde https://docs.docker.com/get-docker/${NC}"
        exit 1
    fi

    if ! docker compose version &> /dev/null; then
        echo -e "${RED}✗ Docker Compose (v2) no está disponible. Actualiza Docker.${NC}"
        exit 1
    fi
}

check_workspace() {
    if [ ! -f "artisan" ] || [ ! -f "composer.json" ]; then
        echo -e "${RED}✗ Este script debe ejecutarse desde la raíz del proyecto BeStrong.${NC}"
        exit 1
    fi
}

compose() {
    (cd "$SCRIPT_DIR/docker" && docker compose "$@")
}

get_running_count() {
    local count
    count=$(docker inspect -f '{{.State.Running}}' bestrong_app bestrong_vite 2>/dev/null | grep -c "true") || count=0
    echo "$count"
}

cmd_status() {
    echo -e "${CYAN}━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━${NC}"
    echo -e "${CYAN}  Estado del entorno BeStrong${NC}"
    echo -e "${CYAN}━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━${NC}"
    echo ""
    echo -e "${YELLOW}Contenedores Docker:${NC}"
    compose ps
    echo ""

    echo -e "${YELLOW}Puertos y Conectividad:${NC}"
    if curl -s -o /dev/null -w "%{http_code}" http://localhost:80 &>/dev/null; then
        local code
        code=$(curl -s -o /dev/null -w "%{http_code}" http://localhost:80 || echo "000")
        echo -e "  ${GREEN}✓ HTTP (Puerto 80):${NC} respondiendo (HTTP $code) → ${BLUE}http://localhost${NC}"
    else
        echo -e "  ${RED}✗ HTTP (Puerto 80):${NC} sin respuesta"
    fi

    if curl -s -o /dev/null http://localhost:5173 &>/dev/null; then
        echo -e "  ${GREEN}✓ Vite (Puerto 5173):${NC} respondiendo → ${BLUE}http://localhost:5173${NC}"
    else
        echo -e "  ${RED}✗ Vite (Puerto 5173):${NC} sin respuesta"
    fi
    echo ""

    echo -e "${YELLOW}Base de datos local:${NC}"
    if [ -f "database/database.sqlite" ]; then
        local db_size
        db_size=$(du -h database/database.sqlite | awk '{print $1}')
        echo -e "  ${GREEN}✓ database/database.sqlite presente${NC} (tamaño: $db_size)"
    else
        echo -e "  ${RED}✗ database/database.sqlite no encontrada${NC}"
    fi
    echo ""

    echo -e "${YELLOW}Imágenes Docker:${NC}"
    for img in bestrong-app bestrong-vite; do
        if docker image inspect "$img" &>/dev/null; then
            local img_size
            img_size=$(docker image inspect -f '{{.Size}}' "$img" 2>/dev/null | awk '{printf "%.1f MB", $1/1024/1024}')
            echo -e "  ${GREEN}✓ $img:${NC} disponible ($img_size)"
        else
            echo -e "  ${RED}✗ $img:${NC} no encontrada (se construirá automáticamente al iniciar)"
        fi
    done
    echo ""

    echo -e "${YELLOW}Volúmenes Docker:${NC}"
    for vol in docker_app_vendor docker_app_storage docker_app_bootstrap_cache docker_vite_node_modules; do
        local label="${vol#docker_}"
        case "$label" in
            app_vendor) label="vendor (Composer)" ;;
            app_storage) label="storage (Logs/Subidas)" ;;
            app_bootstrap_cache) label="cache (Bootstrap)" ;;
            vite_node_modules) label="node_modules (Vite)" ;;
        esac
        if docker volume inspect "$vol" &>/dev/null; then
            echo -e "  ${GREEN}✓ $label:${NC} presente"
        else
            echo -e "  ${RED}✗ $label:${NC} no creado (se creará automáticamente al iniciar)"
        fi
    done
    echo ""

    echo -e "${YELLOW}Archivos de Logs en Host (Auditoría Forense):${NC}"
    local log_files=(
        "docker/logs/nginx/access.log:Nginx Accesos"
        "docker/logs/nginx/error.log:Nginx Errores"
        "docker/logs/laravel/laravel.log:Laravel App"
        "docker/logs/supervisor/supervisord.log:Supervisor"
    )
    for entry in "${log_files[@]}"; do
        local file="${entry%%:*}"
        local desc="${entry##*:}"
        if [ -f "$file" ]; then
            local size
            size=$(du -h "$file" 2>/dev/null | awk '{print $1}')
            echo -e "  ${GREEN}✓ $desc:${NC} $file ($size)"
        else
            echo -e "  ${YELLOW}ℹ $desc:${NC} $file (se creará con la primera petición)"
        fi
    done
    echo ""
}

cmd_stop() {
    local running_count
    running_count=$(get_running_count)
    if [ "$running_count" -eq 0 ]; then
        echo -e "${GREEN}✓ Los contenedores ya estaban detenidos.${NC}"
        return 0
    fi
    echo -e "${YELLOW}Deteniendo contenedores de BeStrong...${NC}"
    compose down
    echo -e "${GREEN}✓ Contenedores detenidos correctamente.${NC}"
    echo -e "  (La base de datos y los volúmenes están intactos. Usa './setup.sh start' para reanudar)"
}

cmd_restart() {
    echo -e "${YELLOW}Reiniciando contenedores...${NC}"
    compose restart
    echo -e "${GREEN}✓ Contenedores reiniciados.${NC}"
    echo "Esperando a que los servicios inicien..."
    sleep 2
    cmd_status
}

cmd_logs() {
    echo -e "${YELLOW}Conectando a los logs en tiempo real (Ctrl+C para salir)...${NC}"
    compose logs -f "$@"
}

cmd_clean() {
    echo -e "${YELLOW}Eliminando todo el entorno Docker de BeStrong (contenedores, volúmenes e imágenes)...${NC}"
    compose down -v --remove-orphans 2>/dev/null || true

    for img in bestrong-app bestrong-vite; do
        if docker image inspect "$img" &>/dev/null; then
            docker rmi "$img" 2>/dev/null || true
            echo -e "  ${GREEN}✓ Imagen $img eliminada.${NC}"
        else
            echo -e "  ${YELLOW}⚠ La imagen $img no existía.${NC}"
        fi
    done

    echo ""
    echo -e "${GREEN}✓ Todo el entorno Docker (contenedores, volúmenes e imágenes) ha sido eliminado.${NC}"
    echo -e "  (La base de datos SQLite y tu .env se mantienen intactos. Usa 'bash setup.sh start' para reconstruir y arrancar)"
}

cmd_rmi() {
    local target="$1"

    if [ -z "$target" ]; then
        echo -e "${YELLOW}Uso: bash setup.sh rmi <app|vite|all>${NC}"
        echo ""
        echo "Opciones disponibles:"
        echo -e "  ${GREEN}app${NC}   Elimina la imagen bestrong-app (sin detener el contenedor si está activo)."
        echo -e "  ${GREEN}vite${NC}  Elimina la imagen bestrong-vite (sin detener el contenedor si está activo)."
        echo -e "  ${GREEN}all${NC}   Elimina ambas imágenes Docker."
        echo ""
        exit 1
    fi

    case "$target" in
        app)
            echo -e "${YELLOW}Eliminando imagen Docker 'bestrong-app'...${NC}"
            if docker image inspect bestrong-app &>/dev/null; then
                docker rmi -f bestrong-app 2>/dev/null || true
                echo -e "  ${GREEN}✓ Imagen 'bestrong-app' eliminada.${NC}"
                echo -e "  ${YELLOW}ℹ La imagen ya no existe localmente. En el próximo arranque del contenedor se descargará/construirá de nuevo.${NC}"
            else
                echo -e "  ${YELLOW}⚠ La imagen 'bestrong-app' no existía.${NC}"
            fi
            echo ""
            echo -e "${GREEN}✓ Operación completada.${NC}"
            ;;
        vite)
            echo -e "${YELLOW}Eliminando imagen Docker 'bestrong-vite'...${NC}"
            if docker image inspect bestrong-vite &>/dev/null; then
                docker rmi -f bestrong-vite 2>/dev/null || true
                echo -e "  ${GREEN}✓ Imagen 'bestrong-vite' eliminada.${NC}"
                echo -e "  ${YELLOW}ℹ La imagen ya no existe localmente. En el próximo arranque del contenedor se descargará/construirá de nuevo.${NC}"
            else
                echo -e "  ${YELLOW}⚠ La imagen 'bestrong-vite' no existía.${NC}"
            fi
            echo ""
            echo -e "${GREEN}✓ Operación completada.${NC}"
            ;;
        all)
            echo -e "${YELLOW}Eliminando imágenes Docker de BeStrong ('bestrong-app' y 'bestrong-vite')...${NC}"
            for img in bestrong-app bestrong-vite; do
                if docker image inspect "$img" &>/dev/null; then
                    docker rmi -f "$img" 2>/dev/null || true
                    echo -e "  ${GREEN}✓ Imagen '$img' eliminada.${NC}"
                else
                    echo -e "  ${YELLOW}⚠ La imagen '$img' no existía.${NC}"
                fi
            done
            echo ""
            echo -e "  ${YELLOW}ℹ Las imágenes ya no existen localmente. En el próximo arranque se descargarán/construirán de nuevo.${NC}"
            echo ""
            echo -e "${GREEN}✓ Operación completada.${NC}"
            ;;
        *)
            echo -e "${RED}Opción no válida para rmi: '$target'${NC}"
            echo -e "Uso: ${YELLOW}bash setup.sh rmi <app|vite|all>${NC}"
            exit 1
            ;;
    esac
}

cmd_rmv() {
    local target="$1"

    if [ -z "$target" ]; then
        echo -e "${YELLOW}Uso: bash setup.sh rmv <vendor|storage|cache|node_modules|all>${NC}"
        echo ""
        echo "Opciones disponibles:"
        echo -e "  ${GREEN}vendor${NC}        Volumen de Composer (docker_app_vendor)"
        echo -e "  ${GREEN}storage${NC}       Volumen de almacenamiento (docker_app_storage)"
        echo -e "  ${GREEN}cache${NC}         Volumen de caché de Laravel (docker_app_bootstrap_cache)"
        echo -e "  ${GREEN}node_modules${NC}  Volumen de dependencias Vite (docker_vite_node_modules)"
        echo -e "  ${GREEN}all${NC}           Elimina los 4 volúmenes anteriores de BeStrong"
        echo ""
        exit 1
    fi

    local vol_name=""
    local service_to_stop=""

    case "$target" in
        vendor)
            vol_name="docker_app_vendor"
            service_to_stop="app"
            ;;
        storage)
            vol_name="docker_app_storage"
            service_to_stop="app"
            ;;
        cache|bootstrap_cache)
            vol_name="docker_app_bootstrap_cache"
            service_to_stop="app"
            ;;
        node_modules)
            vol_name="docker_vite_node_modules"
            service_to_stop="vite"
            ;;
        all)
            echo -e "${YELLOW}⚠ Para eliminar todos los volúmenes, es necesario detener previamente los contenedores de BeStrong.${NC}"
            echo -e "  Deteniendo contenedores..."
            compose down 2>/dev/null || true
            for v in docker_app_vendor docker_app_storage docker_app_bootstrap_cache docker_vite_node_modules; do
                if docker volume inspect "$v" &>/dev/null; then
                    docker volume rm "$v" &>/dev/null && echo -e "  ${GREEN}✓ Volumen $v eliminado.${NC}" || echo -e "  ${RED}✗ No se pudo eliminar $v (en uso).${NC}"
                else
                    echo -e "  ${YELLOW}⚠ El volumen $v no existía.${NC}"
                fi
            done
            echo ""
            echo -e "${GREEN}✓ Volúmenes eliminados.${NC}"
            echo -e "  (Todos los volúmenes Docker han sido purgados. La base de datos local y el .env se mantienen intactos)"
            echo -e "  (Se regenerarán automáticamente al arrancar con 'bash setup.sh start')"
            return 0
            ;;
        *)
            echo -e "${RED}Opción no válida para rmv: '$target'${NC}"
            echo -e "Uso: ${YELLOW}bash setup.sh rmv <vendor|storage|cache|node_modules|all>${NC}"
            exit 1
            ;;
    esac

    echo -e "${YELLOW}⚠ Para eliminar el volumen '$vol_name', es necesario detener previamente el contenedor '$service_to_stop'.${NC}"
    echo -e "  Deteniendo contenedor '$service_to_stop'..."
    compose stop "$service_to_stop" 2>/dev/null || true
    compose rm -f "$service_to_stop" 2>/dev/null || true

    echo -e "${YELLOW}Eliminando volumen Docker '$vol_name'...${NC}"
    if docker volume inspect "$vol_name" &>/dev/null; then
        docker volume rm "$vol_name" &>/dev/null && echo -e "  ${GREEN}✓ Volumen $vol_name eliminado con éxito.${NC}" || echo -e "  ${RED}✗ No se pudo eliminar $vol_name (en uso).${NC}"
    else
        echo -e "  ${YELLOW}⚠ El volumen $vol_name no existía.${NC}"
    fi

    echo ""
    echo -e "${GREEN}✓ Operación completada.${NC}"
    case "$target" in
        vendor)
            echo -e "  (Dependencias Composer eliminadas. Se repondrán desde la imagen al arrancar con 'bash setup.sh start')"
            ;;
        cache|bootstrap_cache)
            echo -e "  (Caché de rutas y configuración de Laravel eliminada. Se regenerará al arrancar con 'bash setup.sh start')"
            ;;
        node_modules)
            echo -e "  (Dependencias Vite eliminadas. Se repondrán desde la imagen al arrancar con 'bash setup.sh start')"
            ;;
        storage)
            echo -e "  (Archivos subidos, sesiones y logs eliminados. La base de datos y el .env se mantienen intactos)"
            ;;
    esac
}

cmd_reset() {
    local force="$1"
    if [ "$force" != "true" ] && [ -t 0 ]; then
        echo -e "${RED}⚠ ATENCIÓN: El modo reset es DESTRUCTIVO.${NC}"
        echo -e "  Eliminará contenedores, imágenes, volúmenes, el fichero .env y la base de datos SQLite."
        read -rp "  ¿Estás seguro de que deseas restablecer todo desde cero? [s/N]: " confirm
        case "$confirm" in
            [sS]|[yY]|[sS][iI]) ;;
            *)
                echo -e "${YELLOW}Operación cancelada. No se ha modificado nada.${NC}"
                exit 0
                ;;
        esac
    fi

    echo -e "${RED}[RESET] Destruyendo entorno existente...${NC}"
    compose down -v --remove-orphans 2>/dev/null || true
    docker rmi bestrong-app bestrong-vite 2>/dev/null || true

    [ -f .env ] && rm -f .env && echo -e "  ${GREEN}✓ .env eliminado${NC}"
    [ -f database/database.sqlite ] && rm -f database/database.sqlite \
        && echo -e "  ${GREEN}✓ database.sqlite eliminado${NC}"

    echo -e "  ${GREEN}✓ Entorno destruido. Procediendo con la instalación limpia...${NC}"
    echo ""

    cmd_start --build --force-setup
}

cmd_start() {
    local force_build=false
    local force_setup=false

    for arg in "$@"; do
        [ "$arg" = "--build" ] && force_build=true
        [ "$arg" = "--force-setup" ] && force_setup=true
    done

    local running_count
    running_count=$(get_running_count)

    # 1. Comprobar si ya están corriendo
    if [ "$running_count" -eq 2 ] && [ "$force_setup" = false ] && [ "$force_build" = false ]; then
        echo -e "${YELLOW}⚠ Todos los contenedores de BeStrong ya están en ejecución.${NC}"
        echo ""

        if [ -t 0 ]; then
            read -rp "  ¿Deseas reiniciarlos? [s/N]: " confirm_restart
            case "$confirm_restart" in
                [sS]|[yY]|[sS][iI])
                    echo ""
                    cmd_restart
                    exit 0
                    ;;
                *)
                    echo -e "  ${GREEN}✓ Se mantienen los contenedores en ejecución.${NC}"
                    echo ""
                    cmd_status
                    exit 0
                    ;;
            esac
        else
            echo "Los contenedores ya están levantados. Estado actual:"
            cmd_status
            exit 0
        fi
    elif [ "$running_count" -eq 1 ] && [ "$force_setup" = false ] && [ "$force_build" = false ]; then
        echo -e "${YELLOW}⚠ Estado parcial detectado: uno de los contenedores está detenido.${NC}"
        echo -e "  Levantando el servicio faltante sin reiniciar el que ya está activo..."
        echo ""
    fi

    # 2. Comprobar puertos libres
    if ss -tlnp 2>/dev/null | grep -q ':80 ' || netstat -tlnp 2>/dev/null | grep -q ':80 '; then
        # Solo advertir si el que ocupa el puerto no es docker
        if [ "$running_count" -eq 0 ]; then
            echo -e "  ${YELLOW}⚠ El puerto 80 parece estar en uso por otro proceso del host.${NC}"
        fi
    fi

    # 3. Determinar si se necesita construir o basta con levantar
    local missing_images=()
    docker image inspect bestrong-app &>/dev/null || missing_images+=("bestrong-app")
    docker image inspect bestrong-vite &>/dev/null || missing_images+=("bestrong-vite")

    local missing_volumes=()
    for vol in docker_app_vendor docker_app_storage docker_app_bootstrap_cache docker_vite_node_modules; do
        docker volume inspect "$vol" &>/dev/null || missing_volumes+=("${vol#docker_}")
    done

    if [ "$force_build" = true ]; then
        echo -e "${YELLOW}[1/3] Reconstruyendo imágenes (--build solicitado)...${NC}"
        compose up --build -d
    elif [ ${#missing_images[@]} -gt 0 ]; then
        echo -e "${YELLOW}[1/3] Imagen(es) no encontrada(s): ${missing_images[*]}.${NC}"
        echo -e "  Construyendo automáticamente antes de arrancar..."
        compose up --build -d
    elif [ ${#missing_volumes[@]} -gt 0 ]; then
        echo -e "${YELLOW}[1/3] Volumen(es) Docker no encontrado(s): ${missing_volumes[*]}.${NC}"
        echo -e "  Inicializando volúmenes automáticamente desde las imágenes base..."
        compose up -d
    else
        echo -e "${YELLOW}[1/3] Levantando contenedores existentes...${NC}"
        compose up -d
    fi

    # 4. Esperar a que la app esté lista
    echo ""
    echo -e "${YELLOW}[2/3] Esperando a que la aplicación esté lista...${NC}"
    local retries=20
    until compose exec -T app php artisan --version &>/dev/null || [ $retries -eq 0 ]; do
        echo -n "."
        sleep 2
        retries=$((retries - 1))
    done
    echo ""

    if [ $retries -eq 0 ]; then
        echo -e "${RED}✗ La aplicación no respondió a tiempo. Revisa los logs con:${NC}"
        echo -e "   bash setup.sh logs app"
        exit 1
    fi

    # 5. Poblar catálogo de ejercicios si la base de datos es nueva
    echo ""
    echo -e "${YELLOW}[3/3] Verificando catálogo de ejercicios en base de datos...${NC}"
    local ej_count
    ej_count=$(compose exec -T app php -r '
        try {
            $pdo = new PDO("sqlite:/var/www/html/database/database.sqlite");
            $stmt = $pdo->query("SELECT count(*) FROM ejercicios");
            echo (int) $stmt->fetchColumn();
        } catch (\Throwable $e) {
            echo 0;
        }
    ' 2>/dev/null || echo "0")

    if [ "$ej_count" -eq 0 ]; then
        echo -e "  Descargando ejercicios desde la API wger.de (puede tardar un par de minutos)..."
        docker run --rm --network host --entrypoint php \
            -v "$SCRIPT_DIR":/var/www/html \
            -v docker_app_vendor:/var/www/html/vendor \
            bestrong-app /var/www/html/artisan db:seed --force
        echo -e "  ${GREEN}✓ Catálogo de ejercicios importado con éxito${NC}"
    else
        echo -e "  ${GREEN}✓ Catálogo ya poblado ($ej_count ejercicios disponibles)${NC}"
    fi

    # 6. Resumen final
    echo ""
    echo -e "${GREEN}━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━${NC}"
    echo -e "${GREEN}  ✓ BeStrong está listo${NC}"
    echo -e "${GREEN}━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━${NC}"
    echo ""
    echo -e "  🌐 App:   ${BLUE}http://localhost${NC}"
    echo -e "  ⚡ Vite:  ${BLUE}http://localhost:5173${NC}"
    echo ""
    echo -e "  Regístrate en ${BLUE}http://localhost/register${NC} para crear tu primer usuario."
    echo ""
    echo -e "  Comandos rápidos de gestión:"
    echo -e "  ${YELLOW}bash setup.sh status${NC}     → ver estado del entorno"
    echo -e "  ${YELLOW}bash setup.sh stop${NC}       → detener contenedores"
    echo -e "  ${YELLOW}bash setup.sh logs${NC}       → ver logs en tiempo real"
    echo -e "  ${YELLOW}bash setup.sh build${NC}      → reconstruir imágenes (sin borrar datos)"
    echo -e "  ${YELLOW}bash setup.sh reset${NC}      → restablecer todo desde cero (destructivo)"
    echo -e "  ${YELLOW}cd docker && ./tinker.sh${NC} → consola interactiva Laravel Tinker"
    echo ""
}

# ── Punto de entrada principal ──────────────────────────────
check_prerequisites
check_workspace

ACTION="${1:-start}"
shift || true

case "$ACTION" in
    start)
        cmd_start "$@"
        ;;
    stop|down|--stop)
        cmd_stop
        ;;
    restart|--restart)
        cmd_restart
        ;;
    status|ps|--status)
        cmd_status
        ;;
    logs|--logs)
        cmd_logs "$@"
        ;;
    build|--build)
        cmd_start --build "$@"
        ;;
    clean|--clean)
        cmd_clean
        ;;
    rmi|--rmi)
        cmd_rmi "$@"
        ;;
    rmv|--rmv)
        cmd_rmv "$@"
        ;;
    reset|--reset)
        FORCE_RESET=false
        for a in "$@"; do
            [ "$a" = "-y" ] || [ "$a" = "--yes" ] && FORCE_RESET=true
        done
        cmd_reset "$FORCE_RESET"
        ;;
    help|--help|-h)
        print_help
        ;;
    *)
        echo -e "${RED}Comando desconocido: '$ACTION'${NC}"
        echo -e "Ejecuta ${YELLOW}bash setup.sh --help${NC} para ver la lista de comandos disponibles."
        exit 1
        ;;
esac
