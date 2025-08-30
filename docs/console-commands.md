# Console Commands

## Custom Artisan Commands

Starter kit ini dilengkapi dengan beberapa custom Artisan commands untuk mempercepat development process.

### 1. Generate Service Command

**Command:** `php artisan make:service {name}`

**Deskripsi:** Generate service class beserta store dan update request classes.

**Contoh Penggunaan:**
```bash
php artisan make:service UserService
```

**Yang akan di-generate:**
- `app/Services/UserService.php` - Service class utama
- `app/Http/Requests/StoreUserRequest.php` - Request validation untuk create
- `app/Http/Requests/UpdateUserRequest.php` - Request validation untuk update

**Struktur Service:**
Service yang di-generate akan memiliki method standar:
- `index()` - List data dengan pagination
- `store()` - Create new record
- `show()` - Get single record
- `update()` - Update existing record
- `destroy()` - Delete record

### 2. Generate API Controller Command

**Command:** `php artisan make:api {name}`

**Deskripsi:** Generate API controller dengan resource dan collection classes.

**Contoh Penggunaan:**
```bash
php artisan make:api UserController
```

**Yang akan di-generate:**
- `app/Http/Controllers/Api/UserController.php` - API Controller
- `app/Http/Resources/UserResource.php` - Single resource transformer
- `app/Http/Resources/UserCollection.php` - Collection resource transformer

**Fitur Controller:**
- RESTful API endpoints (index, store, show, update, destroy)
- Integrated dengan Service pattern
- Response formatting menggunakan Resource classes
- Error handling

### 3. Generate Query Command

**Command:** `php artisan make:query {name}`

**Deskripsi:** Generate query builder class untuk advanced database queries.

**Contoh Penggunaan:**
```bash
php artisan make:query UserQuery
```

**Yang akan di-generate:**
- `app/Repositories/UserQuery.php` - Query builder class

**Fitur Query Builder:**
- Integration dengan Spatie Query Builder
- Support untuk filtering, sorting, dan searching
- Relationships handling
- Custom query scopes

### 4. Generate Postman Collection

**Command:** `php artisan postman:generate-groups [--environment]`

**Deskripsi:** Generate Postman collection dengan group-based URL support.

**Contoh Penggunaan:**
```bash
# Generate collection saja
php artisan postman:generate-groups

# Generate collection + environment file
php artisan postman:generate-groups --environment
```

**Hasil Generate:**
- Collection file di `storage/postman/`
- Environment variables (jika menggunakan flag `--environment`)
- Grouping berdasarkan route prefix
- Auto-generated request examples

**Konfigurasi:**
Edit `config/postman.php` untuk customization:
- Base URL
- Headers default
- Authentication setup
- Route filtering

### Tips Penggunaan

1. **Workflow Development:**
   ```bash
   # 1. Generate service untuk business logic
   php artisan make:service PostService
   
   # 2. Generate API controller
   php artisan make:api PostController
   
   # 3. Generate query builder jika butuh advanced queries
   php artisan make:query PostQuery
   
   # 4. Generate Postman collection untuk testing
   php artisan postman:generate-groups --environment
   ```

2. **Naming Convention:**
   - Service: `{Model}Service` (contoh: `UserService`)
   - Controller: `{Model}Controller` (contoh: `UserController`)
   - Query: `{Model}Query` (contoh: `UserQuery`)

3. **Customization:**
   Semua stub files bisa di-customize di folder `stubs/`:
   - `Service.stub` - Template service class
   - `Api.stub` - Template API controller
   - `Query.stub` - Template query builder
   - `Resource.stub` - Template resource class
   - `Collection.stub` - Template collection class
   - `StoreRequest.stub` - Template store request
   - `UpdateRequest.stub` - Template update request

### Integration dengan Package Lain

Commands ini terintegrasi dengan package-package yang sudah ter-install:
- **Spatie Query Builder** - untuk advanced filtering
- **Spatie Laravel Permission** - untuk authorization
- **Laravel Sanctum** - untuk API authentication
- **Spatie Media Library** - untuk file handling
