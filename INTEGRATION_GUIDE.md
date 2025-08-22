# Panduan Integrasi Admin Panel dengan Website Utama

## Overview
Dokumen ini menjelaskan bagaimana admin panel terintegrasi dengan website utama Legian Medical Clinic. Integrasi ini memungkinkan pengelolaan konten website secara dinamis melalui interface admin yang user-friendly.

## Struktur Integrasi

### 1. Routing Integration
```
Website Utama: /
Admin Panel: /admin
```

**File Routes:**
- `routes/web.php` - Routes website utama
- `routes/admin.php` - Routes admin panel (di-include di web.php)

### 2. Authentication System
- **Website Utama**: Tidak memerlukan login (public access)
- **Admin Panel**: Menggunakan guard 'admin' terpisah dari user biasa

**Konfigurasi Auth:**
```php
// config/auth.php
'guards' => [
    'web' => ['driver' => 'session', 'provider' => 'users'],
    'admin' => ['driver' => 'session', 'provider' => 'admin_users'],
],
'providers' => [
    'users' => ['driver' => 'eloquent', 'model' => App\Models\User::class],
    'admin_users' => ['driver' => 'eloquent', 'model' => App\Models\AdminUser::class],
]
```

### 3. Data Flow Integration

#### A. Data dari Admin Panel → Website Utama
```
Admin Panel (CRUD) → Database → PageController → Views
```

**Contoh Flow:**
1. Admin menambah dokter baru di admin panel
2. Data disimpan ke tabel `doctors`
3. `PageController` mengambil data dari database
4. Data ditampilkan di section doctors di website utama

#### B. Shared Models
Semua model digunakan bersama antara admin panel dan website utama:
- `Doctor` - Data dokter
- `Service` - Data layanan
- `ContentPage` - Konten statis (About, FAQ, Contact)
- `AdminUser` - Data admin
- `ActivityLog` - Log aktivitas admin

### 4. File Upload Integration

#### Storage Structure
```
storage/app/public/
├── doctors/     # Foto dokter
├── icons/       # Icon layanan
└── uploads/     # File lainnya
```

#### URL Access
- **Admin Panel**: Upload file melalui form
- **Website Utama**: Akses file melalui `asset('storage/...')`

#### Model Accessors
```php
// Doctor.php
public function getPhotoUrlAttribute()
{
    if ($this->photo) {
        return asset('storage/' . $this->photo);
    }
    return asset('images/default-doctor.jpg');
}

// Service.php
public function getIconUrlAttribute()
{
    if ($this->icon) {
        return asset('storage/' . $this->icon);
    }
    return asset('images/default-icon.png');
}
```

### 5. Content Management Integration

#### Multi-language Support
- Konten disimpan dalam bahasa Indonesia dan Inggris
- Website utama menampilkan konten sesuai locale yang dipilih
- Admin panel memungkinkan edit konten dalam kedua bahasa

#### Content Pages
- `about_us` - Halaman About Us
- `faq` - Halaman FAQ
- `contact` - Halaman Contact

#### Database Structure
```sql
content_pages
├── page_key (about_us, faq, contact)
├── locale (id, en)
├── title
├── content
└── meta_data (JSON)
```

### 6. Navigation Integration

#### Admin Panel Access
Link admin panel ditambahkan di navbar website utama:
```html
<a href="{{ route('admin.login') }}" class="btn btn-outline-primary btn-sm" title="Admin Panel">
    <i class="fas fa-cog"></i>
</a>
```

#### Admin Panel Navigation
- Dashboard dengan statistik real-time
- Manajemen Dokter
- Manajemen Layanan
- Manajemen Konten
- Link ke website utama

### 7. Security Integration

#### Middleware Protection
```php
// AdminMiddleware.php
public function handle(Request $request, Closure $next)
{
    if (!Auth::guard('admin')->check()) {
        return redirect()->route('admin.login');
    }
    
    $admin = Auth::guard('admin')->user();
    if (!$admin->is_active) {
        Auth::guard('admin')->logout();
        return redirect()->route('admin.login');
    }
    
    return $next($request);
}
```

#### Activity Logging
Semua aktivitas admin dicatat:
- Login/Logout
- CRUD operations
- IP address tracking
- User agent tracking

### 8. View Integration

#### Website Utama Views
- `resources/views/index.blade.php` - Layout utama
- `resources/views/partials/_*.blade.php` - Section components
- Menggunakan data dari `PageController`

#### Admin Panel Views
- `resources/views/admin/layouts/app.blade.php` - Admin layout
- `resources/views/admin/*/index.blade.php` - List views
- `resources/views/admin/*/create.blade.php` - Create forms
- `resources/views/admin/*/edit.blade.php` - Edit forms

### 9. Controller Integration

#### Website Utama Controllers
- `PageController` - Menangani halaman utama
- `LanguageController` - Menangani pergantian bahasa

#### Admin Panel Controllers
- `AuthController` - Autentikasi admin
- `DashboardController` - Dashboard admin
- `DoctorController` - CRUD dokter
- `ServiceController` - CRUD layanan
- `ContentController` - Edit konten

### 10. Database Integration

#### Shared Tables
```sql
doctors          - Data dokter
services         - Data layanan
content_pages    - Konten statis
admin_users      - Data admin
activity_logs    - Log aktivitas
```

#### Data Relationships
- Semua tabel memiliki timestamps
- Soft deletes untuk data protection
- Foreign key relationships untuk activity logs

## Cara Menggunakan Integrasi

### 1. Akses Admin Panel
```
URL: http://localhost/legian-medical-clinic/admin
Username: admin
Password: admin123
```

### 2. Menambah Dokter
1. Login ke admin panel
2. Klik "Manajemen Dokter"
3. Klik "Tambah Dokter"
4. Isi form dan upload foto
5. Klik "Simpan"
6. Dokter akan muncul di website utama

### 3. Menambah Layanan
1. Klik "Manajemen Layanan"
2. Klik "Tambah Layanan"
3. Isi form dan upload icon
4. Klik "Simpan"
5. Layanan akan muncul di website utama

### 4. Edit Konten
1. Klik "Manajemen Konten"
2. Pilih halaman yang akan diedit
3. Edit konten dalam bahasa Indonesia dan Inggris
4. Klik "Simpan"
5. Konten akan terupdate di website utama

### 5. Lihat Hasil
1. Klik link "Lihat Website" di admin panel
2. Atau buka `http://localhost/legian-medical-clinic`
3. Perubahan dari admin panel akan terlihat

## Troubleshooting

### 1. File Upload Tidak Muncul
```bash
# Recreate storage link
php artisan storage:link

# Check permissions
chmod -R 755 storage/
chmod -R 755 public/storage/
```

### 2. Admin Login Gagal
```bash
# Check database
php artisan migrate:status

# Re-seed admin user
php artisan db:seed --class=AdminUserSeeder
```

### 3. Data Tidak Muncul di Website
```bash
# Check database connection
php artisan config:cache

# Check models
php artisan tinker
>>> App\Models\Doctor::count()
>>> App\Models\Service::count()
```

### 4. Permission Denied
```bash
# Fix file permissions
chmod -R 755 storage/
chmod -R 755 public/storage/
chmod -R 755 bootstrap/cache/
```

## Best Practices

### 1. Security
- Selalu gunakan HTTPS di production
- Regular backup database
- Monitor activity logs
- Update Laravel dan dependencies

### 2. Performance
- Optimize images sebelum upload
- Use caching untuk konten statis
- Monitor database queries
- Regular maintenance

### 3. Content Management
- Backup konten sebelum edit besar
- Test perubahan di staging
- Maintain content versioning
- Regular content review

## Monitoring & Maintenance

### 1. Regular Tasks
- Backup database harian
- Monitor disk usage
- Check error logs
- Update security patches

### 2. Performance Monitoring
- Monitor response time
- Check database performance
- Monitor file storage usage
- Track user activity

### 3. Security Monitoring
- Monitor login attempts
- Check activity logs
- Monitor file uploads
- Regular security audit

---

**Version**: 1.0.0  
**Last Updated**: January 2024  
**Maintained By**: Development Team
