# ⚡ Quick Deploy OneHost (30 phút)

## 1️⃣ Lấy Database Info từ OneHost cPanel (2 min)

1. Login: https://onehost.me/
2. Vào **Quản lý MySQL** → Click database `nzdrpuqdhoting_csxhuyhoang`
3. Copy thông tin:
   - **Host**: onehost-wphm022606.000nethost.com
   - **Cổng**: 3306
   - **Tên tài khoản**: nzdrpuqdhoting_csxhuyhoang
   - **Mật khẩu**: (lấy từ Tên tài khoản cơ sở dữ liệu)

## 2️⃣ Upload Code (10 min)

### Via SSH (Nhanh nhất):
```bash
# SSH vào OneHost
ssh user@onehost-wphm022606.000nethost.com

# Vào thư mục public_html
cd public_html

# Clone project từ GitHub (nếu có)
git clone https://github.com/your-repo/akauto-shop.git

# Hoặc upload FTP (dùng WinSCP/FileZilla)
```

### Via FTP:
- Dùng FileZilla / WinSCP
- Host: `ftp://onehost.me` hoặc SSH port 22
- Upload vào `public_html/akauto-shop`

## 3️⃣ Install Dependencies (5 min)

```bash
cd public_html/akauto-shop

# Install composer packages
composer install --no-dev --optimize-autoloader

# Install npm packages (if needed)
npm install && npm run build
```

## 4️⃣ Setup Environment (5 min)

```bash
# Copy config template
cp .env.example .env

# Edit .env
nano .env
```

**Thay đổi cần thiết:**
```env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://chamsocxehuyhoang.me

DB_HOST=onehost-wphm022606.000nethost.com
DB_DATABASE=nzdrpuqdhoting_csxhuyhoang
DB_USERNAME=nzdrpuqdhoting_csxhuyhoang
DB_PASSWORD=(lấy từ OneHost)
```

## 5️⃣ Initialize Database (5 min)

```bash
# Generate app key
php artisan key:generate

# Run migrations
php artisan migrate --force

# Create admin user
php artisan tinker
> App\Models\User::create(['name'=>'Admin','email'=>'admin@example.com','password'=>bcrypt('your-password'),'is_admin'=>1])
> exit
```

## 6️⃣ Configure Domain (3 min)

**OneHost cPanel:**
1. Vào **Tên miền** → **Thêm tên miền**
2. Domain: `chamsocxehuyhoang.me`
3. Document Root: `public_html/akauto-shop/public`
4. Click **Tạo**

Hoặc dùng Addon Domain.

## 7️⃣ Final Setup

```bash
# Set permissions
chmod -R 755 public
chmod -R 775 storage
chmod -R 775 bootstrap/cache

# Cache everything
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Create storage symlink
php artisan storage:link
```

## 8️⃣ Test Website

- ✅ Visit: https://chamsocxehuyhoang.me
- ✅ Admin login: https://chamsocxehuyhoang.me/admin/login
- ✅ Email: admin@example.com
- ✅ Password: your-password

---

## 🔧 Troubleshooting

### ❌ 500 Error
```bash
tail -f storage/logs/laravel.log
# Check error message
```

### ❌ Database Connection Error
- Kiểm tra DB_HOST, DB_USERNAME, DB_PASSWORD ở `.env`
- Kiểm tra database được tạo ở OneHost

### ❌ File Upload Error
```bash
chmod -R 775 storage
```

### ❌ Slow Site
```bash
php artisan config:cache
php artisan route:cache
```

---

## 📋 Before Going Live

- [ ] Change admin password
- [ ] Update company phone/address ở config/company.php
- [ ] Add some products & categories
- [ ] Test checkout flow
- [ ] Setup email notifications (optional)
- [ ] Install SSL (usually auto on OneHost)
- [ ] Setup backup (OneHost usually has this)

---

## 🚀 One-Liner Deploy (sau lần đầu)

```bash
cd public_html/akauto-shop && git pull && composer install --no-dev && php artisan migrate --force && php artisan optimize
```

**Done! 🎉**
