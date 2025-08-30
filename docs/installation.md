# Installation Guide

## Panduan Instalasi Laravel API Starter Kit

### Prerequisites
- PHP 8.3 atau lebih tinggi
- Composer
- PostgreSQL (default) atau database lain sesuai kebutuhan

### Langkah-langkah Instalasi

#### 1. Copy Environment File
```bash
copy .env.example .env
```

#### 2. Generate Application Key
```bash
php artisan key:generate
```

#### 3. Install Dependencies
```bash
composer install
```

#### 4. Database Configuration
Edit file `.env` dan sesuaikan konfigurasi database:
```env
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=your_database_name
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

Jalankan migrasi database:
```bash
php artisan migrate
```

#### 5. Setup Laravel Boost MCP
Generate konfigurasi Laravel Boost untuk code editor:
```bash
php artisan boost:install
```
Pilih code editor yang sesuai dengan pilihan Anda (VS Code, PhpStorm, dll).

#### 6. Setup Laradumps
Generate konfigurasi Laradumps untuk debugging:
```bash
php artisan laradumps:install
```

### Package Development Dependencies

Starter kit ini menggunakan beberapa package development yang sangat berguna:

- **Laravel Boost** (`laravel/boost`): MCP server untuk Laravel development
- **Laradumps** (`laradumps/laradumps`): Tool debugging yang powerful
- **Laravel Postman** (`yasin_tgh/laravel-postman`): Generator collection Postman

### Konfigurasi Tambahan

#### Media Library
Jika menggunakan media uploads, publish storage link:
```bash
php artisan storage:link
```

#### Permissions
Seeder default sudah tersedia untuk roles dan permissions:
```bash
php artisan db:seed
```

### Development Tools

Starter kit ini dilengkapi dengan berbagai console commands untuk mempercepat development. Lihat [Console Commands](console-commands.md) untuk detail lengkap.

### Testing

Jalankan test suite:
```bash
php artisan test
```

### Production Deployment

Untuk deployment production, pastikan untuk:
1. Set `APP_ENV=production` di `.env`
2. Set `APP_DEBUG=false`
3. Jalankan `php artisan config:cache`
4. Jalankan `php artisan route:cache`
5. Jalankan `php artisan view:cache`
