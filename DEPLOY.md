# Deploy Akauto Shop - Hướng Dẫn Gọn Gàng

## 📋 Tóm Tắt

Chi 3 bước đơn giản để chạy website:

1. **Upload files** → `/public_html/`
2. **Cấu hình** → `wp-config.php` (database credentials)
3. **Chạy setup commands** → Server setup hoàn tất

---

## 🚀 BƯỚC 1: Upload Files

### Cách 1: File Manager (Dễ nhất)
- Đăng nhập 1Panel File Manager
- Navigate to `/public_html/`
- Upload tất cả files từ project

### Cách 2: Git Clone (Nhanh hơn)
```bash
ssh nzdrpuqdhosting@onehost-wphn022606.000nethost.com
cd /public_html
git clone https://github.com/bason1610-lang/huyhoang.git .
```

---

## ⚙️ BƯỚC 2: Cấu Hình Database

### Chỉnh sửa `wp-config.php` ở server

File `wp-config.php` tại `/public_html/wp-config.php`:

```php
define('DB_NAME', 'nzdrpuqdhosting_csxhuyhoang');
define('DB_USER', 'nzdrpuqdhosting_csxhuyhoang');
define('DB_PASSWORD', 'Admin@123');
define('DB_HOST', 'localhost');
```

**Vì sao:**
- `DB_NAME` = Database name từ iNET
- `DB_USER` = Database username từ iNET
- `DB_PASSWORD` = Database password từ iNET
- `DB_HOST` = localhost (server iNET)

Nếu credentials khác, cập nhật lại. Ready!

---

## 🔧 BƯỚC 3: Setup Trên Server (Copy-Paste Commands)

SSH vào server:
```bash
ssh nzdrpuqdhosting@onehost-wphn022606.000nethost.com
cd /public_html
```

### 3.1 Thiết lập Permissions
```bash
chmod -R 755 .
chmod -R 777 storage bootstrap/cache
```

### 3.2 Cài Composer Dependencies (nếu vendor/ chưa có)
```bash
if [ ! -d "vendor" ]; then
    php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
    php composer-setup.php --quiet
    php composer.phar install --no-dev --optimize-autoloader
    rm composer-setup.php
fi
```

### 3.3 Laravel Setup
```bash
# Create needed directories
mkdir -p storage/logs storage/framework/cache storage/framework/sessions storage/framework/views

# Clear and rebuild cache
php artisan config:clear
php artisan cache:clear
php artisan view:clear
php artisan config:cache

# Migrate database (first time only)
php artisan migrate --force

# (Optional) Seed demo data
# php artisan db:seed --class=AkautoDemoSeeder --force
```

### 3.4 Done! Verify
```bash
# Check files are in place
ls -la index.php wp-config.php .env

# Test database
php artisan tinker
# Type: DB::statement('SELECT 1')
# Should return: true
# Type: exit
```

---

## ✅ Test Website

| Địa chỉ | Kỳ vọng |
|---------|--------|
| https://chamsocxehuyhoang.vn | Trang chủ + danh sách sản phẩm |
| https://chamsocxehuyhoang.vn/admin | Trang login |
| Credentials: admin@example.com / admin123 | Đăng nhập admin dashboard |

---

## 🐛 Nếu Gặp 500 Error

```bash
# Enable debug
sed -i 's/APP_DEBUG=false/APP_DEBUG=true/' .env
php artisan config:cache

# Check logs
tail -100 storage/logs/laravel.log

# Disable debug
sed -i 's/APP_DEBUG=true/APP_DEBUG=false/' .env
php artisan config:cache
```

---

## 📊 Folder Structure (Tại `/public_html/`)

```
/public_html/
├── wp-config.php        ← Database config (⚠️ MUST update)
├── index.php            ← Laravel entry point
├── .env                 ← App config (sẵn sàng)
├── app/                 ← Source code
├── bootstrap/           ← Framework bootstrap
├── config/              ← Configuration files
├── database/            ← Migrations & seeders
├── public/              ← Static assets (CSS, images, JS)
├── resources/           ← Views & resources
├── routes/              ← Web & API routes
├── storage/             ← Logs, cache, sessions (← chmod 777)
├── vendor/              ← Composer packages
└── ... (artisan, composer.json, package.json, etc.)
```

---

## ✨ Đó thôi!

**Tóm lại 3 bước:**
1. ✅ Upload files to `/public_html/`
2. ✅ Update database credentials in `wp-config.php`
3. ✅ Run server setup commands

**Website sẽ chạy tại:** https://chamsocxehuyhoang.vn 🎉

---

## 📞 Commands Reference

```bash
# SSH Login
ssh nzdrpuqdhosting@onehost-wphn022606.000nethost.com

# Go to project
cd /public_html

# Set permissions
chmod -R 777 storage bootstrap/cache

# Install dependencies
php composer.phar install --no-dev

# Clear cache
php artisan config:clear && php artisan cache:clear

# Rebuild cache
php artisan config:cache

# Migrate database
php artisan migrate --force

# View logs
tail -50 storage/logs/laravel.log
```

---

**Ready? Start at BƯỚC 1! 🚀**
