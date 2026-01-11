#!/bin/bash

# Script mejorado para preparar el primer commit
# Version 1.1 - Siempre se ejecuta desde la raíz del proyecto

# Colores
GREEN='\033[0;32m'
BLUE='\033[0;34m'
YELLOW='\033[1;33m'
RED='\033[0;31m'
NC='\033[0m'

echo "🚀 Preparando primer commit del Blog"
echo "====================================="
echo ""

# ============================================
# PASO 1: IR A LA RAÍZ DEL PROYECTO
# ============================================

# Obtener el directorio donde está este script
SCRIPT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)"

# Si el script está en una subcarpeta (ej: scripts/), subir un nivel
if [[ "$SCRIPT_DIR" == *"/scripts" ]]; then
    PROJECT_ROOT="$(cd "$SCRIPT_DIR/.." && pwd)"
else
    # Si está en la raíz, usar el directorio actual
    PROJECT_ROOT="$SCRIPT_DIR"
fi

# Ir a la raíz del proyecto
cd "$PROJECT_ROOT" || {
    echo -e "${RED}❌ Error: No se pudo acceder al directorio del proyecto${NC}"
    exit 1
}

echo -e "${BLUE}📍 Directorio de trabajo: $(pwd)${NC}"
echo ""

# ============================================
# PASO 2: VALIDAR QUE ESTAMOS EN UN PROYECTO LARAVEL
# ============================================

# Verificar que estamos en un proyecto Laravel
if [ ! -f "composer.json" ] && [ ! -f "artisan" ]; then
    echo -e "${RED}❌ Error: No parece ser un proyecto Laravel${NC}"
    echo "   No se encontró composer.json ni artisan"
    echo ""
    echo "📍 Ubicación actual: $(pwd)"
    echo "📂 Archivos aquí:"
    ls -1 | head -10
    echo ""
    echo "💡 Asegúrate de ejecutar este script desde la raíz de tu proyecto"
    exit 1
fi

echo -e "${GREEN}✅ Proyecto Laravel detectado${NC}"
echo ""

# ============================================
# PASO 3: VERIFICAR REPOSITORIOS ANIDADOS
# ============================================

echo -e "${BLUE}🔍 Verificando repositorios Git anidados...${NC}"

# Buscar todos los directorios .git
GIT_DIRS=$(find . -name ".git" -type d 2>/dev/null)
GIT_COUNT=$(echo "$GIT_DIRS" | grep -c ".git")

if [ $GIT_COUNT -gt 1 ]; then
    echo -e "${YELLOW}⚠️  Se encontraron múltiples repositorios Git:${NC}"
    echo "$GIT_DIRS"
    echo ""
    echo -e "${YELLOW}Esto puede causar problemas. Repositorios encontrados:${NC}"
    echo "$GIT_DIRS" | while read -r git_dir; do
        if [ ! -z "$git_dir" ]; then
            echo "  - $git_dir"
        fi
    done
    echo ""
    read -p "¿Quieres que elimine los repositorios anidados? (s/n): " remove_nested
    
    if [ "$remove_nested" = "s" ]; then
        echo "$GIT_DIRS" | while read -r git_dir; do
            if [ ! -z "$git_dir" ] && [ "$git_dir" != "./.git" ]; then
                echo -e "${BLUE}Eliminando: $git_dir${NC}"
                rm -rf "$git_dir"
            fi
        done
        echo -e "${GREEN}✅ Repositorios anidados eliminados${NC}"
    fi
fi

echo -e "${GREEN}✅ No hay repositorios anidados${NC}"
echo ""

# ============================================
# PASO 4: INICIALIZAR O VERIFICAR REPOSITORIO
# ============================================

# Verificar si ya existe repositorio
if [ -d ".git" ]; then
    echo -e "${YELLOW}⚠️  Ya existe un repositorio Git en este directorio${NC}"
    echo ""
    
    # Verificar si hay commits
    if git log &>/dev/null; then
        echo "📊 Historial de commits:"
        git log --oneline -5
        echo ""
        echo -e "${YELLOW}Ya tienes commits en este repositorio.${NC}"
        read -p "¿Quieres continuar y crear un nuevo commit inicial? (s/n): " continue
        if [ "$continue" != "s" ]; then
            echo "Operación cancelada."
            exit 0
        fi
    else
        echo "El repositorio existe pero no tiene commits."
    fi
else
    echo -e "${BLUE}📦 Inicializando repositorio Git...${NC}"
    git init
    git branch -M main
    echo -e "${GREEN}✅ Repositorio inicializado${NC}"
    echo ""
fi

# ============================================
# PASO 5: CREAR .gitignore
# ============================================

echo -e "${BLUE}📝 Creando .gitignore...${NC}"
cat > .gitignore << 'EOF'
# Laravel
/node_modules
/public/hot
/public/storage
/storage/*.key
/vendor
.env
.env.backup
.env.production
.phpunit.result.cache
Homestead.json
Homestead.yaml
auth.json
npm-debug.log
yarn-error.log

# IDEs
/.idea
/.vscode
*.sublime-project
*.sublime-workspace
.DS_Store
Thumbs.db

# Logs
*.log

# Composer
composer.phar
composer.lock

# NPM
package-lock.json

# Build
/public/build
/public/mix-manifest.json

# Testing
/coverage
/.phpunit.cache

# Temporal
*.tmp
*.bak
*.swp
*~
EOF

echo -e "${GREEN}✅ .gitignore creado${NC}"
echo ""

# ============================================
# PASO 6: CREAR .env.example
# ============================================

if [ ! -f ".env.example" ]; then
    echo -e "${BLUE}📝 Creando .env.example...${NC}"
    if [ -f ".env" ]; then
        # Copiar .env pero ocultar valores sensibles
        cp .env .env.example
        # Limpiar valores sensibles en .env.example
        sed -i 's/DB_PASSWORD=.*/DB_PASSWORD=/' .env.example
        sed -i 's/APP_KEY=.*/APP_KEY=/' .env.example
        sed -i 's/MAIL_PASSWORD=.*/MAIL_PASSWORD=/' .env.example 2>/dev/null
        echo -e "${GREEN}✅ .env.example creado desde .env${NC}"
    else
        echo -e "${YELLOW}⚠️  No existe .env, omitiendo .env.example${NC}"
    fi
    echo ""
fi

# ============================================
# PASO 7: VERIFICAR ARCHIVOS SENSIBLES
# ============================================

echo -e "${BLUE}🔒 Verificando archivos sensibles...${NC}"

# Remover .env del tracking si está
if git ls-files --error-unmatch .env &>/dev/null; then
    echo -e "${YELLOW}⚠️  .env está trackeado, removiendo...${NC}"
    git rm --cached .env 2>/dev/null || true
fi

echo -e "${GREEN}✅ Archivos sensibles verificados${NC}"
echo ""

# ============================================
# PASO 8: AGREGAR ARCHIVOS
# ============================================

echo -e "${BLUE}📦 Agregando archivos al staging...${NC}"
git add .

# Mostrar resumen
echo ""
echo -e "${BLUE}📊 Resumen de archivos a commitear:${NC}"
git status --short | head -20
echo ""

# Contar archivos
TOTAL_FILES=$(git diff --cached --numstat | wc -l)
echo -e "${GREEN}Total de archivos: $TOTAL_FILES${NC}"
echo ""

# ============================================
# PASO 9: CREAR EL COMMIT
# ============================================

echo -e "${BLUE}💾 Creando commit inicial...${NC}"

git commit -m "chore: initial commit - Blog v1.0.0

Sistema de blog completo listo para producción.

Características implementadas:
- Sistema de autenticación y usuarios
- CRUD de posts con editor
- Sistema de categorías y tags
- Comentarios
- Panel de administración
- Sistema de búsqueda
- Responsive design
- Optimización SEO
- Paginación
- Validaciones de formularios
- Middleware de autorización
- Gestión de imágenes
- Sistema de roles y permisos

Tecnologías:
- Laravel 11.x
- PHP 8.4
- MySQL
- Blade templates
- Tailwind CSS
- JavaScript/Alpine.js

Stack del servidor:
- Ubuntu 24 LTS
- Nginx
- PHP-FPM 8.4

Estado: Listo para despliegue en producción

Version: 1.0.0"

if [ $? -eq 0 ]; then
    echo -e "${GREEN}✅ Commit inicial creado exitosamente${NC}"
else
    echo -e "${RED}❌ Error al crear commit${NC}"
    exit 1
fi
echo ""

# ============================================
# PASO 10: CREAR TAG
# ============================================

echo -e "${BLUE}🏷️  Creando tag v1.0.0...${NC}"
git tag -a v1.0.0 -m "Release v1.0.0 - Primera versión en producción

Blog completo con todas las funcionalidades implementadas.
Listo para despliegue en servidor de producción."

echo -e "${GREEN}✅ Tag v1.0.0 creado${NC}"
echo ""

# ============================================
# RESUMEN FINAL
# ============================================

echo "================================================"
echo -e "${GREEN}🎉 ¡Repositorio Git preparado exitosamente!${NC}"
echo "================================================"
echo ""
echo "📋 Información del commit:"
git log -1 --stat
echo ""
echo "🏷️  Tags:"
git tag -l -n1
echo ""
echo "📊 Estado del repositorio:"
git log --oneline --graph --all
echo ""
echo "🔗 Próximos pasos:"
echo "================================================"
echo ""
echo "1. Crear repositorio en GitHub:"
echo "   - Ve a: https://github.com/new"
echo "   - Nombre: nombre-de-tu-blog"
echo "   - Descripción: Sistema de blog en Laravel"
echo "   - Visibilidad: Privado (recomendado)"
echo ""
echo "2. Conectar repositorio remoto:"
echo "   git remote add origin git@github.com:tu-usuario/nombre-blog.git"
echo ""
echo "3. Verificar remote:"
echo "   git remote -v"
echo ""
echo "4. Push del código y tags:"
echo "   git push -u origin main"
echo "   git push origin v1.0.0"
echo ""
echo "5. Configurar despliegue automático:"
echo "   - Copia .github/workflows/deploy.yml a tu proyecto"
echo "   - Configura los Secrets en GitHub"
echo "   - Sigue la guía en CHECKLIST.md"
echo ""
echo "💡 Importante:"
echo "   - El archivo .env NO está en el repositorio ✅"
echo "   - Recuerda configurar .env en el servidor"
echo "   - El tag v1.0.0 marca esta versión en producción"
echo ""
echo "¡Listo para hacer push y desplegar! 🚀"
