# Setup Admin Panel dengan Tailwind CSS

Dokumentasi ini menjelaskan cara menggunakan layout Tailwind CSS untuk admin panel Legian Medical Clinic.

## Layout Baru

Layout Tailwind CSS telah dibuat di `resources/views/admin/layouts/app-tailwind.blade.php`.

## Cara Menggunakan

### 1. Extend Layout Tailwind

Di view file Anda, gunakan:

```blade
@extends('admin.layouts.app-tailwind')

@section('title', 'Judul Halaman')
@section('page-title', 'Judul yang Ditampilkan di Header')

@section('content')
    <!-- Konten Anda di sini -->
@endsection
```

### 2. Contoh Dashboard

Dashboard sudah dibuat dengan Tailwind di `resources/views/admin/dashboard/index-tailwind.blade.php`.

### 3. Mengubah Controller untuk Menggunakan View Tailwind

Di controller, Anda bisa menambahkan logika untuk memilih view:

```php
public function index()
{
    $data = [...];
    
    // Gunakan view Tailwind jika tersedia
    if (view()->exists('admin.doctors.index-tailwind')) {
        return view('admin.doctors.index-tailwind', compact('data'));
    }
    
    // Fallback ke view Bootstrap
    return view('admin.doctors.index', compact('data'));
}
```

## Fitur Layout Tailwind

1. **Sidebar Navigation**
   - Menu otomatis aktif berdasarkan route
   - Menu "Manajemen User" hanya muncul untuk Super Admin
   - Responsive dengan hamburger menu untuk mobile

2. **Header**
   - Judul halaman dinamis
   - User menu dengan dropdown
   - Logout dan pengaturan akun

3. **Alert Messages**
   - Success dan error messages
   - Auto-dismissible

4. **Mobile Responsive**
   - Sidebar bisa dibuka/tutup di mobile
   - Overlay untuk mobile

## Menu yang Tersedia

- Dashboard
- Manajemen Dokter
- Manajemen Layanan
- Manajemen Konten
- Manajemen FAQ
- Manajemen User (hanya Super Admin)

## Styling

Layout menggunakan Tailwind CSS dengan:
- Font Inter
- Custom scrollbar
- Smooth transitions
- Shadow effects

## Next Steps

Untuk mengkonversi view lainnya ke Tailwind:

1. Copy view yang ada (misal: `doctors/index.blade.php`)
2. Buat versi Tailwind (misal: `doctors/index-tailwind.blade.php`)
3. Update controller untuk menggunakan view Tailwind
4. Test dan sesuaikan styling sesuai kebutuhan

