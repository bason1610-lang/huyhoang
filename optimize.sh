#!/bin/bash

# Optimization script for production
# Run after deployment

echo "🔧 Optimizing AKauto Shop for Production..."

# 1. Clear all cache
echo "Clearing cache..."
php artisan cache:clear
php artisan config:clear
php artisan view:clear
php artisan route:clear

# 2. Rebuild cache
echo "Setting up optimizations..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

# 3. Dump autoloader
echo "Optimizing autoloader..."
composer dump-autoload --optimize

# 4. Set permissions
echo "Setting permissions..."
chmod -R 755 public
chmod -R 775 storage bootstrap/cache

# 5. Create storage link
echo "Creating storage link..."
php artisan storage:link || true

echo "✅ Optimization complete!"
