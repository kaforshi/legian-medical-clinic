# Hero Slider Management Guide

## Overview
Hero Slider adalah fitur yang memungkinkan admin untuk mengelola gambar slider pada hero section website utama. Fitur ini menggantikan hero section statis dengan image slider yang dinamis dan dapat dikelola melalui admin panel.

## Fitur Utama

### 1. **Manajemen Gambar Slider**
- ✅ Tambah gambar slider baru
- ✅ Edit gambar slider existing
- ✅ Hapus gambar slider
- ✅ Upload gambar dengan preview
- ✅ Validasi format dan ukuran file

### 2. **Konten Dinamis**
- ✅ Judul slider (opsional)
- ✅ Deskripsi slider (opsional)
- ✅ Button text dan URL (opsional)
- ✅ Fallback ke konten default jika tidak diisi

### 3. **Pengaturan Tampilan**
- ✅ Urutan slider (drag & drop)
- ✅ Status aktif/nonaktif
- ✅ Auto-rotation dengan Bootstrap carousel
- ✅ Responsive design

### 4. **Admin Panel Integration**
- ✅ Menu Hero Slider di sidebar admin
- ✅ Dashboard statistics
- ✅ Quick action button
- ✅ Activity logging

## Cara Menggunakan

### 1. **Akses Hero Slider Management**
```
URL: http://localhost/legian-medical-clinic/admin/hero-sliders
Login: admin / admin123
```

### 2. **Tambah Slider Baru**
1. Klik "Tambah Slider"
2. Upload gambar (wajib)
3. Isi judul, deskripsi, button (opsional)
4. Set urutan dan status
5. Klik "Simpan Slider"

### 3. **Edit Slider Existing**
1. Klik tombol edit (ikon pensil)
2. Modifikasi konten yang diinginkan
3. Upload gambar baru (opsional)
4. Klik "Update Slider"

### 4. **Atur Urutan Slider**
1. Di halaman index, gunakan drag & drop
2. Atur urutan sesuai keinginan
3. Klik "Simpan Urutan"

### 5. **Hapus Slider**
1. Klik tombol hapus (ikon tempat sampah)
2. Konfirmasi penghapusan
3. Gambar akan otomatis dihapus dari storage

## Struktur Database

### Tabel: `hero_sliders`
```sql
CREATE TABLE hero_sliders (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    title VARCHAR(255) NULL,
    description TEXT NULL,
    image VARCHAR(255) NOT NULL,
    button_text VARCHAR(100) NULL,
    button_url VARCHAR(500) NULL,
    is_active BOOLEAN DEFAULT TRUE,
    sort_order INT DEFAULT 0,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    deleted_at TIMESTAMP NULL
);
```

### Field Description
- **title**: Judul slider (opsional)
- **description**: Deskripsi slider (opsional)
- **image**: Path gambar slider (wajib)
- **button_text**: Teks button (opsional)
- **button_url**: URL button (opsional)
- **is_active**: Status aktif slider
- **sort_order**: Urutan tampilan
- **timestamps**: Created, updated, deleted

## File Storage

### Struktur Folder
```
storage/app/public/
└── hero-sliders/
    ├── image1.jpg
    ├── image2.jpg
    └── image3.jpg
```

### URL Access
```
Website: asset('storage/hero-sliders/image.jpg')
Admin: Storage::disk('public')->store('hero-sliders', 'image')
```

## Spesifikasi Gambar

### Format yang Didukung
- ✅ JPEG (.jpg, .jpeg)
- ✅ PNG (.png)
- ✅ GIF (.gif)

### Batasan
- **Ukuran maksimal**: 5MB
- **Ukuran yang disarankan**: 1920x1080px
- **Rasio aspek**: 16:9 atau 21:9

### Tips Optimasi
1. Gunakan gambar berkualitas tinggi
2. Kompres gambar sebelum upload
3. Pastikan teks tetap terbaca di atas gambar
4. Gunakan overlay untuk meningkatkan keterbacaan

## Frontend Implementation

### Bootstrap Carousel
```html
<div id="heroCarousel" class="carousel slide" data-bs-ride="carousel">
    <!-- Indicators -->
    <div class="carousel-indicators">...</div>
    
    <!-- Slides -->
    <div class="carousel-inner">
        <div class="carousel-item active">
            <div class="hero-slide" style="background-image: url('{{ $slider->image_url }}');">
                <!-- Content -->
            </div>
        </div>
    </div>
    
    <!-- Controls -->
    <button class="carousel-control-prev">...</button>
    <button class="carousel-control-next">...</button>
</div>
```

### CSS Styling
```css
.hero-section {
    height: 100vh;
    min-height: 600px;
    overflow: hidden;
}

.hero-slide {
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
}

.hero-overlay {
    background: rgba(0, 0, 0, 0.4);
}
```

## Fallback System

### Jika Tidak Ada Slider
```php
@if($heroSliders->count() > 0)
    <!-- Hero Slider -->
    <div id="heroCarousel">...</div>
@else
    <!-- Fallback Hero -->
    <div class="hero-bg">
        <h1>{{ __('messages.heroTitle') }}</h1>
        <p>{{ __('messages.heroSubtitle') }}</p>
        <a href="#contact">{{ __('messages.heroButton') }}</a>
    </div>
@endif
```

## Admin Panel Features

### 1. **Index Page**
- Tabel daftar slider
- Preview gambar thumbnail
- Status aktif/nonaktif
- Aksi edit/hapus
- Pagination

### 2. **Create Page**
- Form upload gambar
- Input konten slider
- Preview gambar real-time
- Validasi form
- Tips penggunaan

### 3. **Edit Page**
- Form edit konten
- Preview gambar existing
- Preview gambar baru
- Update tanpa upload ulang

### 4. **Sortable List**
- Drag & drop reordering
- Visual feedback
- Auto-update urutan
- AJAX save order

## Security Features

### 1. **File Upload Validation**
- MIME type validation
- File size limit
- Image format restriction
- Secure file storage

### 2. **Access Control**
- Admin middleware protection
- CSRF protection
- File permission management
- Activity logging

### 3. **Data Protection**
- Soft deletes
- File cleanup on delete
- Input sanitization
- SQL injection prevention

## Performance Optimization

### 1. **Image Optimization**
- Responsive image sizing
- Lazy loading support
- Browser caching
- CDN ready

### 2. **Database Optimization**
- Indexed queries
- Eager loading
- Pagination
- Caching support

### 3. **Frontend Optimization**
- Minimal JavaScript
- CSS optimization
- Bootstrap integration
- Mobile responsive

## Troubleshooting

### 1. **Gambar Tidak Muncul**
```bash
# Check storage link
php artisan storage:link

# Check permissions
chmod -R 755 storage/
chmod -R 755 public/storage/
```

### 2. **Upload Gagal**
```bash
# Check file size limit
php.ini: upload_max_filesize = 10M
php.ini: post_max_size = 10M

# Check storage permissions
chmod -R 755 storage/
```

### 3. **Slider Tidak Berputar**
```javascript
// Check Bootstrap JS
// Check carousel initialization
// Check console errors
```

### 4. **Urutan Tidak Tersimpan**
```bash
# Check CSRF token
# Check JavaScript console
# Check network requests
```

## Best Practices

### 1. **Content Management**
- Gunakan judul yang menarik
- Deskripsi singkat dan jelas
- Button call-to-action yang efektif
- Konsistensi dalam styling

### 2. **Image Management**
- Optimize gambar sebelum upload
- Gunakan rasio aspek yang konsisten
- Test keterbacaan teks
- Backup gambar penting

### 3. **Performance**
- Batasi jumlah slider (max 5-7)
- Kompres gambar optimal
- Monitor file storage usage
- Regular cleanup

## Monitoring & Maintenance

### 1. **Regular Tasks**
- Backup gambar slider
- Monitor storage usage
- Check slider performance
- Update konten berkala

### 2. **Analytics**
- Track slider engagement
- Monitor load times
- User interaction metrics
- Performance metrics

---

**Version**: 1.0.0  
**Last Updated**: January 2024  
**Maintained By**: Development Team
