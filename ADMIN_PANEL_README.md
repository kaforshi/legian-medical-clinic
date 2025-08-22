# Admin Panel - Legian Medical Clinic

## Overview
Admin Panel untuk website Legian Medical Clinic yang memungkinkan pengelolaan konten website secara dinamis melalui interface yang user-friendly.

## Fitur Utama

### 1. Autentikasi Admin
- **Login/Logout**: Sistem autentikasi yang aman untuk admin
- **Role Management**: Dua level admin (Super Admin dan Admin)
- **Session Management**: Pengelolaan sesi yang aman

### 2. Dashboard Ringkasan
- **Statistik Real-time**: Jumlah dokter, layanan, dan konten
- **Aktivitas Terbaru**: Log aktivitas admin dalam 7 hari terakhir
- **Quick Actions**: Akses cepat ke fitur-fitur utama

### 3. Manajemen Dokter
- **CRUD Dokter**: Tambah, edit, hapus data dokter
- **Upload Foto**: Upload dan preview foto dokter
- **Status Aktif/Nonaktif**: Kontrol visibilitas dokter
- **Informasi Lengkap**: Nama, spesialisasi, pendidikan, pengalaman

### 4. Manajemen Layanan
- **CRUD Layanan**: Tambah, edit, hapus layanan medis
- **Upload Icon**: Upload icon untuk setiap layanan
- **Pengaturan Harga**: Input harga layanan (opsional)
- **Sort Order**: Pengaturan urutan tampilan

### 5. Manajemen Konten Statis
- **Multi-bahasa**: Konten dalam bahasa Indonesia dan Inggris
- **Halaman Dinamis**: About Us, FAQ, Contact
- **Rich Text Editor**: Editor WYSIWYG untuk konten
- **Meta Data**: Informasi tambahan seperti alamat, telepon

### 6. Activity Logging
- **Log Aktivitas**: Mencatat semua aktivitas admin
- **Detail Log**: IP address, user agent, waktu
- **Audit Trail**: Tracking perubahan data

## Akses Admin Panel

### URL Admin Panel
```
http://localhost/legian-medical-clinic/admin
```

### Kredensial Default
```
Username: admin
Password: admin123

Username: staff  
Password: staff123
```

## Struktur Database

### Tabel Utama
1. **admin_users** - Data admin
2. **doctors** - Data dokter
3. **services** - Data layanan
4. **content_pages** - Konten statis
5. **activity_logs** - Log aktivitas

### Relasi Database
- `admin_users` → `activity_logs` (one-to-many)
- Semua tabel memiliki timestamps dan soft deletes

## File Storage

### Struktur Folder
```
storage/app/public/
├── doctors/     # Foto dokter
├── icons/       # Icon layanan
└── uploads/     # File upload lainnya
```

### Link Symbolic
```bash
php artisan storage:link
```

## Konfigurasi

### Authentication Guard
```php
// config/auth.php
'guards' => [
    'admin' => [
        'driver' => 'session',
        'provider' => 'admin_users',
    ],
],

'providers' => [
    'admin_users' => [
        'driver' => 'eloquent',
        'model' => App\Models\AdminUser::class,
    ],
]
```

### Middleware
```php
// bootstrap/app.php
$middleware->alias([
    'admin' => \App\Http\Middleware\AdminMiddleware::class,
]);
```

## Routes

### Admin Routes
```php
// routes/admin.php
Route::group(['prefix' => 'admin', 'as' => 'admin.'], function () {
    // Authentication
    Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('login', [AuthController::class, 'login']);
    
    // Protected routes
    Route::middleware('admin')->group(function () {
        Route::post('logout', [AuthController::class, 'logout'])->name('logout');
        Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::resource('doctors', DoctorController::class);
        Route::resource('services', ServiceController::class);
        Route::get('content', [ContentController::class, 'index'])->name('content.index');
        Route::get('content/{pageKey}/edit', [ContentController::class, 'edit'])->name('content.edit');
        Route::put('content/{pageKey}', [ContentController::class, 'update'])->name('content.update');
    });
});
```

## Models

### AdminUser
- Extends `Authenticatable`
- Role-based access control
- Activity logging relationship

### Doctor
- Photo upload handling
- Active/inactive status
- Comprehensive doctor information

### Service
- Icon upload handling
- Sort order management
- Price management

### ContentPage
- Multi-language support
- Meta data storage
- Page key management

### ActivityLog
- Admin activity tracking
- IP address logging
- User agent tracking

## Views Structure

```
resources/views/admin/
├── layouts/
│   └── app.blade.php          # Main admin layout
├── auth/
│   └── login.blade.php        # Login page
├── dashboard/
│   └── index.blade.php        # Dashboard
├── doctors/
│   ├── index.blade.php        # Doctor list
│   ├── create.blade.php       # Add doctor
│   └── edit.blade.php         # Edit doctor
├── services/
│   ├── index.blade.php        # Service list
│   ├── create.blade.php       # Add service
│   └── edit.blade.php         # Edit service
└── content/
    ├── index.blade.php        # Content list
    └── edit.blade.php         # Edit content
```

## Security Features

### Authentication
- Password hashing dengan bcrypt
- Session-based authentication
- Remember me functionality
- Account status validation

### Authorization
- Role-based access control
- Middleware protection
- CSRF protection
- Input validation

### Data Protection
- SQL injection prevention
- XSS protection
- File upload validation
- Activity logging

## Installation & Setup

### 1. Database Migration
```bash
php artisan migrate
```

### 2. Seed Data
```bash
php artisan db:seed --class=AdminUserSeeder
php artisan db:seed --class=ContentPageSeeder
```

### 3. Storage Setup
```bash
php artisan storage:link
```

### 4. File Permissions
```bash
chmod -R 755 storage/
chmod -R 755 public/storage/
```

## Usage Guide

### Login Admin
1. Buka `http://localhost/legian-medical-clinic/admin`
2. Masukkan username dan password
3. Klik "Login"

### Menambah Dokter
1. Klik menu "Manajemen Dokter"
2. Klik tombol "Tambah Dokter"
3. Isi form dengan data lengkap
4. Upload foto dokter (opsional)
5. Klik "Simpan"

### Mengelola Layanan
1. Klik menu "Manajemen Layanan"
2. Klik tombol "Tambah Layanan"
3. Isi nama dan deskripsi layanan
4. Upload icon layanan
5. Set harga dan urutan
6. Klik "Simpan"

### Edit Konten
1. Klik menu "Manajemen Konten"
2. Pilih halaman yang akan diedit
3. Edit konten dalam bahasa Indonesia dan Inggris
4. Klik "Simpan"

## Troubleshooting

### Common Issues

#### 1. Storage Link Error
```bash
# Recreate storage link
php artisan storage:link
```

#### 2. Permission Denied
```bash
# Fix file permissions
chmod -R 755 storage/
chmod -R 755 public/storage/
```

#### 3. Database Connection
```bash
# Check database configuration
php artisan config:cache
php artisan migrate:status
```

#### 4. Admin Login Failed
- Pastikan database sudah di-migrate
- Pastikan seeder sudah dijalankan
- Cek kredensial di database

## Maintenance

### Regular Tasks
1. **Backup Database**: Backup berkala
2. **Log Rotation**: Bersihkan log lama
3. **File Cleanup**: Hapus file upload yang tidak terpakai
4. **Security Updates**: Update Laravel dan dependencies

### Monitoring
1. **Activity Logs**: Monitor aktivitas admin
2. **Error Logs**: Cek error log Laravel
3. **Performance**: Monitor response time
4. **Storage**: Monitor disk usage

## Support

Untuk bantuan teknis atau pertanyaan, silakan hubungi:
- Email: support@legianmedical.com
- Phone: +62 361 123456

---

**Version**: 1.0.0  
**Last Updated**: January 2024  
**Laravel Version**: 12.x

