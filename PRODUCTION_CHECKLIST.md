# 📝 Production Deployment Checklist

## Pre-Deployment (Local)

### Code Quality
- [ ] All PHP files use consistent formatting
- [ ] No console.log() left in JS files  
- [ ] No debug statements in code
- [ ] All URLs are relative or use env variables
- [ ] Environment variables are properly configured

### Testing
- [ ] Test login with admin credentials
- [ ] Test viewing products/categories
- [ ] Test adding to cart
- [ ] Test checkout flow
- [ ] Test search functionality
- [ ] Check no 404 errors on main pages
- [ ] Verify banner carousel works
- [ ] Test responsive design

### Assets
- [ ] Run `npm run build` ✅
- [ ] Verify `public/build/` directory exists
- [ ] Check CSS/JS are minified
- [ ] Images are optimized

### Code
- [ ] Run `composer install --no-dev`
- [ ] Run `php artisan optimize`
- [ ] Check logs are empty: `storage/logs/`
- [ ] Database migrations tested locally

---

## Deployment to OneHost

### File Transfer
- [ ] Upload all files except:
  - `.env` (create on server)
  - `.git/` (optional, use SSH clone)
  - `node_modules/` (install on server)
  - `storage/logs/*` (create on server)
  - `vendor/` (install with composer)
- [ ] Verify all files transferred correctly
- [ ] Check file permissions (755 for directories, 644 for files)

### Environment Setup
- [ ] `.env` file created with production values
- [ ] APP_ENV = production
- [ ] APP_DEBUG = false
- [ ] APP_KEY generated (`php artisan key:generate`)
- [ ] Database credentials verified
- [ ] APP_URL points to correct domain

### Database
- [ ] Database exists on OneHost MySQL
- [ ] Migrations run: `php artisan migrate --force`
- [ ] Admin user created with strong password
- [ ] Sample data seeded (if needed)
- [ ] Database backed up

### Web Server
- [ ] Domain points to `public_html/akauto-shop/public/`
- [ ] SSL certificate installed (auto on OneHost)
- [ ] `.htaccess` in place
- [ ] PHP version compatible (8.2+)
- [ ] Composer runs without errors

### File Permissions
- [ ] `storage/` directory writable (775)
- [ ] `bootstrap/cache/` directory writable (775)
- [ ] `public/` directory readable (755)
- [ ] `.env` file readable but protected (640)

### Cache & Optimization
- [ ] `php artisan config:cache` run
- [ ] `php artisan route:cache` run
- [ ] `php artisan view:cache` run
- [ ] Autoloader optimized: `composer dump-autoload --optimize`
- [ ] Storage symlink created: `php artisan storage:link`

---

## Post-Deployment

### Verification
- [ ] Website loads without 500 errors
- [ ] All database queries working
- [ ] File uploads working (check `storage/app/public/`)
- [ ] Session storage working
- [ ] Admin login working
- [ ] All pages responding correctly

### Security
- [ ] HTTPS/SSL enforced
- [ ] No debugging info visible on errors
- [ ] CSRF tokens working
- [ ] Admin panel protected with login
- [ ] Database passwords not in code
- [ ] `.env` file not publicly accessible

### Monitoring
- [ ] Check error logs: `storage/logs/laravel.log`
- [ ] Monitor application performance
- [ ] Setup email alerts for errors (optional)
- [ ] Test email sending (if configured)

### Backup
- [ ] Database backed up
- [ ] Full snapshot of deployment
- [ ] Private keys/certificates backed up
- [ ] `.env` file backed up securely

---

## Common Issues & Fixes

### Issue: 500 Internal Server Error
**Solution:**
```bash
# Check logs
tail storage/logs/laravel.log

# Fix permissions
chmod -R 775 storage bootstrap/cache

# Check PHP version
php -v  # Should be 8.2+

# Check extensions needed
php -m  # Should have: pdo, pdo_mysql, mbstring, bcmath
```

### Issue: Database Connection Fails
**Solution:**
```bash
# Verify credentials in .env
grep DB_ .env

# Test connection
php artisan tinker
> DB::connection()->getPdo()
```

### Issue: Upload/Image Issues
**Solution:**
```bash
# Create storage link
php artisan storage:link

# Fix permissions
chmod -R 775 storage/app/public

# Clear cache
php artisan route:cache
php artisan view:cache
```

### Issue: Slow Performance
**Solution:**
```bash
# Check if caches are built
ls bootstrap/cache/

# Rebuild
php artisan optimize

# Check database query times in logs
tail -f storage/logs/laravel.log
```

---

## Maintenance Tasks

### Daily
- [ ] Monitor error logs
- [ ] Check server disk space
- [ ] Monitor CPU/Memory usage

### Weekly
- [ ] Backup database
- [ ] Review access logs
- [ ] Check for security updates (composer update --dry-run)

### Monthly
- [ ] Update dependencies: `composer update`
- [ ] Review and clean logs
- [ ] Test backup restoration
- [ ] Check SSL certificate expiration

### Yearly
- [ ] Security audit
- [ ] Performance optimization
- [ ] Database maintenance
- [ ] Review logs for patterns

---

## Rollback Procedure

If something goes wrong:

1. **Stop visitor access**
   - Upload maintenance page (`.env` APP_MAINTENANCE_DRIVER)

2. **Restore from backup**
   - Restore database backup
   - Restore code from Git

3. **Verify**
   - Test locally first
   - Test one page on production
   - Re-enable public access

---

## Contact OneHost Support

**If you encounter issues:**
- OneHost cPanel: https://onehost.me/
- Support email: support@onehost.com
- SSH: `ssh user@onehost-wphm022606.000nethost.com`
- FTP Port: 21 or SSH Port: 22

---

**Last Updated:** 2026-04-09  
**Laravel Version:** 12.0+  
**PHP Version Required:** 8.2+
