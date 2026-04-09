# 🚀 Deploy Checklist cho AKauto Shop

## Pre-Deploy (Local)

### Code Preparation
- [x] Chạy `npm run build` - Build Vite assets
- [ ] Clear cache: `php artisan config:clear`
- [ ] Clear cache: `php artisan view:clear`
- [ ] Clear cache: `php artisan cache:clear`
- [ ] Run migrations locally first: `php artisan migrate`
- [ ] Test login: Email `admin@example.com` / Password `admin123`

### Git & Version Control
- [ ] Commit tất cả changes: `git add . && git commit -m "Prepare for production"`
- [ ] Push lên GitHub/GitLab (optional nhưng recommended)

---

## Upload lên OneHost

### FTP/SSH Upload
1. **Lấy FTP credentials từ OneHost cPanel:**
   - Vào cPanel → FTP Accounts
   - Hoặc dùng SSH → cPanel → SSH/Shell

2. **Create folder `akauto-shop` trong `public_html`**
   ```
   public_html/
   └── akauto-shop/
       ├── app/
       ├── bootstrap/
       ├── config/
       ├── database/
       ├── resources/
       ├── routes/
       ├── storage/
       ├── vendor/
       ├── .env (KHÔNG upload - tạo sau)
       ├── .htaccess
       ├── artisan
       ├── composer.json
       ├── package.json
       └── public/
   ```

3. **Upload Files (dùng FTP hoặc Git Clone):**
   ```bash
   # Option 1: SSH vào OneHost rồi clone
   cd public_html
   git clone https://github.com/your-repo/akauto-shop.git akauto-shop
   
   # Option 2: Upload qua FTP (WinSCP, FileZilla)
   # Upload tất cả files trừ .env, .git, node_modules, storage/logs/*
   ```

---

## Setup trên OneHost

### 1. SSH vào Server
```bash
ssh user@onehost-wphm022606.000nethost.com
cd public_html/akauto-shop
```

### 2. Install Dependencies
```bash
composer install --no-dev --optimize-autoloader
```

### 3. Create `.env` File
```bash
cp .env.example .env
```

**Edit `.env` (hoặc dùng nano):**
```bash
nano .env

# Paste config từ .env.production
# Lấy DB info từ OneHost cPanel
DB_HOST=onehost-wphm022606.000nethost.com
DB_DATABASE=nzdrpuqdhoting_csxhuyhoang
DB_USERNAME=nzdrpuqdhoting_csxhuyhoang
DB_PASSWORD=Admin@123 # Change này từ OneHost
```

### 4. Generate APP_KEY
```bash
php artisan key:generate
```

### 5. Run Migrations
```bash
php artisan migrate --force
```

### 6. Seed Admin User
```bash
php artisan tinker
> App\Models\User::updateOrCreate(['email' => 'admin@example.com'], ['name' => 'Admin', 'password' => bcrypt('your-secure-password'), 'is_admin' => 1])
> exit
```

### 7. Set Permissions
```bash
chmod -R 755 public
chmod -R 775 storage
chmod -R 775 bootstrap/cache
chmod 644 .env
```

### 8. Point Domain to public_html/akauto-shop/public
**Cách 1: Edit public_html/.htaccess**
```apache
<IfModule mod_rewrite.c>
    RewriteEngine On
    RewriteCond %{REQUEST_URI} !^/akauto-shop/public/
    RewriteRule ^(.*)$ /akauto-shop/public/$1 [L]
</IfModule>
```

**Cách 2: Setup addon domain trong cPanel**
1. Vào cPanel → Addon Domains
2. Domain: `chamsocxehuyhoang.me`
3. Document Root: `public_html/akauto-shop/public`

---

## Post-Deploy

### Verify Install
```bash
# Check artisan
php artisan --version

# Check database connection
php artisan tinker
> DB::table('users')->count()
> exit

# Check app status
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### Test Website
- [ ] Vào `https://chamsocxehuyhoang.me` - Trang chủ load OK
- [ ] Click vào danh mục - Dropdown sản phẩm hiện
- [ ] Thêm sản phẩm vào giỏ
- [ ] Xem giỏ hàng
- [ ] Đăng nhập admin: `https://chamsocxehuyhoang.me/admin/login`
- [ ] Test quản lý sản phẩm
- [ ] Test upload hình

### Setup SSL Certificate
```bash
# OneHost thường có Let's Encrypt free
# Vào cPanel → AutoSSL / SSL/TLS
# Nó sẽ auto setup https://
```

### Setup Email (Optional)
Nếu muốn gửi email thực:
```bash
# Gmail: Tạo app password từ Google Account
# OneHost SMTP: Dùng SMTP mail server của OneHost
```

---

## Troubleshooting

### 500 Error
```bash
# Check logs
tail -f storage/logs/laravel.log

# Fix permissions
sudo chown -R www-data:www-data .
chmod -R 755 .
chmod -R 775 storage bootstrap/cache
```

### Database Connection Error
```bash
# Verify credentials
php artisan tinker
> DB::connection()->getPdo()

# Check .env
grep DB_ .env
```

### Slow Performance
```bash
# Optimize autoloader
composer dump-autoload --optimize

# Cache configs
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

---

## OneHost File Structure

```
public_html/
├── .htaccess (redirect to akauto-shop)
└── akauto-shop/
    ├── app/
    ├── bootstrap/
    ├── config/
    ├── database/
    ├── public/ ← Point domain here
    │   ├── index.php
    │   ├── css/
    │   ├── images/
    │   └── storage/ → symlink to ../storage/app/public
    ├── resources/
    ├── routes/
    ├── storage/
    │   ├── app/ (writable)
    │   ├── logs/ (writable)
    │   └── framework/ (writable)
    ├── vendor/
    ├── .env (writable by www-data)
    ├── .htaccess
    └── artisan
```

---

## Production Checklist - Final

- [ ] APP_ENV=production
- [ ] APP_DEBUG=false
- [ ] Database migrations runned
- [ ] Admin user created & password changed
- [ ] Storage symlink created
- [ ] File permissions set correctly
- [ ] SSL certificate installed
- [ ] Email configured (if needed)
- [ ] Backup database before go live
- [ ] Monitor logs: `tail -f storage/logs/laravel.log`
- [ ] Test all features one more time

---

## Quick Deploy Command (SSH)

```bash
# SSH vào OneHost
ssh user@onehost-wphm022606.000nethost.com

# Vào folder
cd public_html/akauto-shop

# Pull latest code (if using Git)
git pull

# Install deps
composer install --no-dev

# Run migrations
php artisan migrate --force

# Clear & cache
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Done! 🚀
```

---

**Chú ý:** 
- Thay `your-email@gmail.com` bằng email thực
- Thay `your-secure-password` bằng password mạnh
- Thay `chamsocxehuyhoang.me` bằng domain thực của bạn
