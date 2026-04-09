#!/bin/bash

# AKauto Shop - Production Deployment Script
# Usage: bash deploy.sh

set -e

echo "🚀 Starting AKauto Shop Deployment..."

# Colors
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
RED='\033[0;31m'
NC='\033[0m' # No Color

# 1. Pull latest code
echo -e "${YELLOW}Step 1: Pulling latest code...${NC}"
git pull origin main || true

# 2. Install composer dependencies
echo -e "${YELLOW}Step 2: Installing composer dependencies...${NC}"
composer install --no-dev --optimize-autoloader

# 3. Copy environment file
echo -e "${YELLOW}Step 3: Setting up .env file...${NC}"
if [ ! -f .env ]; then
    cp .env.example .env
    echo -e "${RED}⚠️  Please edit .env with your production values${NC}"
    exit 1
fi

# 4. Generate app key if needed
echo -e "${YELLOW}Step 4: Generating APP_KEY...${NC}"
php artisan key:generate --force || true

# 5. Run migrations
echo -e "${YELLOW}Step 5: Running database migrations...${NC}"
php artisan migrate --force

# 6. Clear cache
echo -e "${YELLOW}Step 6: Clearing cache...${NC}"
php artisan config:clear
php artisan view:clear
php artisan cache:clear

# 7. Cache configs
echo -e "${YELLOW}Step 7: Caching configurations...${NC}"
php artisan config:cache
php artisan route:cache
php artisan view:cache

# 8. Set permissions
echo -e "${YELLOW}Step 8: Setting file permissions...${NC}"
chmod -R 755 public
chmod -R 775 storage
chmod -R 775 bootstrap/cache

# 9. Create storage symlink
echo -e "${YELLOW}Step 9: Creating storage symlink...${NC}"
php artisan storage:link || true

# 10. Restart queue (if using)
# php artisan queue:restart || true

echo -e "${GREEN}✅ Deployment completed successfully!${NC}"
echo -e "${GREEN}Website ready at: $(grep APP_URL .env | cut -d '=' -f2)${NC}"
