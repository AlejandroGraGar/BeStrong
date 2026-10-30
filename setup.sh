#!/bin/bash
set -e

# ─────────────────────────────────────────────
#  BeStrong – Script de primer arranque
#  Uso: bash setup.sh [--reset]
#
#  --reset  Destruye contenedores, imágenes, volúmenes y datos
#           para simular un entorno completamente nuevo.
# ─────────────────────────────────────────────

BLUE='\033[0;34m'
GREEN='\033[0;32m'
RED='\033[0;31m'
YELLOW='\033[1;33m'
NC='\033[0m'

RESET=false
for arg in "$@"; do
  [ "$arg" = "--reset" ] && RESET=true
done

echo -e "${BLUE}"
echo "  ██████╗ ███████╗███████╗████████╗██████╗  ██████╗ ███╗   ██╗ ██████╗ "
echo "  ██╔══██╗██╔════╝██╔════╝╚══██╔══╝██╔══██╗██╔═══██╗████╗  ██║██╔════╝ "
echo "  ██████╔╝█████╗  ███████╗   ██║   ██████╔╝██║   ██║██╔██╗ ██║██║  ███╗"
echo "  ██╔══██╗██╔══╝  ╚════██║   ██║   ██╔══██╗██║   ██║██║╚██╗██║██║   ██║"
echo "  ██████╔╝███████╗███████║   ██║   ██║  ██║╚██████╔╝██║ ╚████║╚██████╔╝"
echo "  ╚═════╝ ╚══════╝╚══════╝   ╚═╝   ╚═╝  ╚═╝ ╚═════╝ ╚═╝  ╚═══╝ ╚═════╝ "
echo -e "${NC}"
echo -e "${BLUE}  Configuración inicial del entorno de desarrollo${NC}"
echo ""

# ── 0. Reset (opcional) ────────────────────────────────────────────────────

if [ "$RESET" = true ]; then
    echo -e "${RED}[RESET] Destruyendo entorno existente...${NC}"

    SCRIPT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)"
    cd "$SCRIPT_DIR/docker"

    docker compose down -v --remove-orphans 2>/dev/null || true
    docker rmi bestrong-app bestrong-vite 2>/dev/null || true
    rm -f .env

    cd ..

    [ -f .env ] && rm -f .env && echo -e "  ${GREEN}✓ .env eliminado${NC}"
    [ -f database/database.sqlite ] && rm -f database/database.sqlite \
        && echo -e "  ${GREEN}✓ database.sqlite eliminado${NC}"

    echo -e "  ${GREEN}✓ Entorno destruido. Procediendo con la instalación limpia...${NC}"
    echo ""
fi

# ── 1. Comprobar prerequisitos ─────────────────────────────────────────────

echo -e "${YELLOW}[1/5] Comprobando prerequisitos...${NC}"

if ! command -v docker &> /dev/null; then
    echo -e "${RED}✗ Docker no está instalado. Instálalo desde https://docs.docker.com/get-docker/${NC}"
    exit 1
fi
echo -e "  ${GREEN}✓ Docker $(docker --version | awk '{print $3}' | tr -d ',')${NC}"

if ! docker compose version &> /dev/null; then
    echo -e "${RED}✗ Docker Compose (v2) no está disponible. Actualiza Docker.${NC}"
    exit 1
fi
echo -e "  ${GREEN}✓ Docker Compose $(docker compose version --short)${NC}"

# ── 2. Verificar que estamos en el directorio correcto ─────────────────────

SCRIPT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)"
cd "$SCRIPT_DIR"

if [ ! -f "artisan" ] || [ ! -f "composer.json" ]; then
    echo -e "${RED}✗ Este script debe ejecutarse desde la raíz del proyecto BeStrong.${NC}"
    exit 1
fi

echo ""
echo -e "${YELLOW}[2/5] Preparando el entorno...${NC}"

if ss -tlnp 2>/dev/null | grep -q ':80 ' || netstat -tlnp 2>/dev/null | grep -q ':80 '; then
    echo -e "  ${YELLOW}⚠ El puerto 80 parece estar en uso. Nginx podría no arrancar correctamente.${NC}"
else
    echo -e "  ${GREEN}✓ Puerto 80 disponible${NC}"
fi

if ss -tlnp 2>/dev/null | grep -q ':5173 ' || netstat -tlnp 2>/dev/null | grep -q ':5173 '; then
    echo -e "  ${YELLOW}⚠ El puerto 5173 parece estar en uso. Vite podría no arrancar correctamente.${NC}"
else
    echo -e "  ${GREEN}✓ Puerto 5173 disponible${NC}"
fi

# ── 3. Construir y arrancar los contenedores ───────────────────────────────

echo ""
echo -e "${YELLOW}[3/5] Construyendo imágenes y arrancando contenedores...${NC}"
echo -e "  (esto puede tardar varios minutos la primera vez)"
echo ""

cd docker/
docker compose up --build -d

# ── 4. Esperar a que la app esté lista ─────────────────────────────────────

echo ""
echo -e "${YELLOW}[4/5] Esperando a que la aplicación esté lista...${NC}"

RETRIES=20
until docker compose exec -T app php artisan --version &>/dev/null || [ $RETRIES -eq 0 ]; do
    echo -n "."
    sleep 2
    RETRIES=$((RETRIES - 1))
done
echo ""

if [ $RETRIES -eq 0 ]; then
    echo -e "${RED}✗ La aplicación no respondió a tiempo. Revisa los logs con:${NC}"
    echo -e "   cd docker && docker compose logs app"
    exit 1
fi

# ── 5. Poblar catálogo de ejercicios si la base de datos es nueva ───────────

echo ""
echo -e "${YELLOW}[5/5] Verificando catálogo de ejercicios...${NC}"
EJ_COUNT=$(docker compose exec -T app php -r '
    try {
        $pdo = new PDO("sqlite:/var/www/html/database/database.sqlite");
        $stmt = $pdo->query("SELECT count(*) FROM ejercicios");
        echo (int) $stmt->fetchColumn();
    } catch (\Throwable $e) {
        echo 0;
    }
' 2>/dev/null || echo "0")

if [ "$EJ_COUNT" -eq 0 ]; then
    echo -e "  Descargando ejercicios desde la API wger.de (puede tardar un par de minutos)..."
    docker run --rm --network host --entrypoint php \
        -v "$SCRIPT_DIR":/var/www/html \
        -v docker_app_vendor:/var/www/html/vendor \
        bestrong-app /var/www/html/artisan db:seed --force
    echo -e "  ${GREEN}✓ Catálogo de ejercicios importado con éxito${NC}"
else
    echo -e "  ${GREEN}✓ Catálogo ya poblado ($EJ_COUNT ejercicios disponibles)${NC}"
fi

# ── Resumen final ──────────────────────────────────────────────────────────

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
echo -e "  Comandos útiles:"
echo -e "  ${YELLOW}cd docker && docker compose logs -f${NC}            → ver logs en tiempo real"
echo -e "  ${YELLOW}cd docker && docker compose down${NC}                → parar"
echo -e "  ${YELLOW}cd docker && docker compose up -d${NC}               → arrancar (sin reconstruir)"
echo -e "  ${YELLOW}cd docker && docker compose up --build -d${NC}       → reconstruir y arrancar"
echo -e "  ${YELLOW}bash setup.sh --reset${NC}                           → destruir todo y empezar de cero"
echo -e "  ${YELLOW}cd docker && docker compose exec app php artisan tinker${NC}  → consola Laravel"
echo ""
