# Multi-Language Hero Slider Guide

## Overview
Fitur Hero Slider sekarang mendukung multi-language (Bahasa Indonesia dan English) yang memungkinkan admin untuk mengelola konten dalam dua bahasa secara terpisah. **PENTING: Hero section tetap menggunakan image slider untuk kedua bahasa, bukan mengubah tampilan.**

## Fitur Multi-Language

### 1. **Dukungan Bahasa**
- ✅ **Bahasa Indonesia (ID)** - Bahasa default
- ✅ **English (EN)** - Bahasa internasional
- ✅ **Language Switcher** - Toggle bahasa di admin panel
- ✅ **Dynamic Content** - Konten berubah sesuai bahasa yang dipilih

### 2. **Struktur Database**
```sql
Table: hero_sliders
├── id (BIGINT, PRIMARY KEY)
├── locale (VARCHAR(5), default: 'id') - Bahasa slider
├── title (VARCHAR, nullable) - Judul Bahasa Indonesia
├── title_en (VARCHAR, nullable) - Judul English
├── description (TEXT, nullable) - Deskripsi Bahasa Indonesia
├── description_en (TEXT, nullable) - Deskripsi English
├── image (VARCHAR, NOT NULL) - Gambar slider
├── button_text (VARCHAR, nullable) - Teks button Bahasa Indonesia
├── button_text_en (VARCHAR, nullable) - Teks button English
├── button_url (VARCHAR, nullable) - URL button
├── is_active (BOOLEAN, default: true)
├── sort_order (INT, default: 0)
├── created_at (TIMESTAMP)
├── updated_at (TIMESTAMP)
└── deleted_at (TIMESTAMP, soft deletes)
```

### 3. **Model Accessors**
```php
// Accessor untuk konten sesuai bahasa
$slider->localized_title      // Judul sesuai bahasa aktif
$slider->localized_description // Deskripsi sesuai bahasa aktif
$slider->localized_button_text // Teks button sesuai bahasa aktif

// Scope untuk filter bahasa
HeroSlider::byLocale('id')    // Filter slider Bahasa Indonesia
HeroSlider::byLocale('en')    // Filter slider English
```

## Cara Menggunakan

### 1. **Admin Panel Language Switcher**
```
Lokasi: Top navbar admin panel (ikon globe)
Fungsi: Ganti bahasa admin panel dan konten
Bahasa: ID (Indonesia) / EN (English)
```

### 2. **Tambah Hero Slider Multi-Language**
1. **Pilih Bahasa** - Pilih bahasa untuk slider ini
2. **Konten Bahasa Indonesia** - Isi judul, deskripsi, button text
3. **Konten English** - Isi judul, deskripsi, button text dalam bahasa Inggris
4. **Upload Gambar** - Gambar sama untuk kedua bahasa
5. **Set URL Button** - URL button sama untuk kedua bahasa
6. **Simpan** - Slider akan tersimpan dengan konten dual language

### 3. **Edit Hero Slider Multi-Language**
1. **Edit Konten** - Modifikasi konten kedua bahasa
2. **Update Gambar** - Ganti gambar jika diperlukan
3. **Save Changes** - Perubahan tersimpan untuk kedua bahasa

### 4. **Frontend Display**
- **Consistent Hero Slider** - Hero section tetap menggunakan image slider untuk kedua bahasa
- **Language-Based Content** - Konten slider berubah sesuai bahasa yang dipilih
- **Auto-Language Detection** - Konten otomatis sesuai bahasa website
- **Fallback System** - Jika bahasa tidak tersedia, gunakan bahasa default
- **Responsive Design** - Tampilan optimal di semua device

## Struktur Konten

### **Slider 1: Pelayanan Kesehatan**
```
Bahasa Indonesia:
- Judul: "Pelayanan Kesehatan Terpercaya"
- Deskripsi: "Kami berkomitmen memberikan pelayanan kesehatan berkualitas tinggi dengan standar internasional"
- Button: "Pelajari Lebih Lanjut"

English:
- Title: "Trusted Healthcare Services"
- Description: "We are committed to providing high-quality healthcare services with international standards"
- Button: "Learn More"
```

### **Slider 2: Tim Dokter**
```
Bahasa Indonesia:
- Judul: "Tim Dokter Profesional"
- Deskripsi: "Didukung oleh tenaga medis berpengalaman dan bersertifikasi untuk memberikan perawatan terbaik"
- Button: "Lihat Dokter Kami"

English:
- Title: "Professional Medical Team"
- Description: "Supported by experienced and certified medical personnel to provide the best care"
- Button: "Meet Our Doctors"
```

### **Slider 3: Layanan Medis**
```
Bahasa Indonesia:
- Judul: "Layanan Medis Lengkap"
- Deskripsi: "Berbagai layanan kesehatan yang dapat disesuaikan dengan kebutuhan Anda"
- Button: "Lihat Layanan"

English:
- Title: "Complete Medical Services"
- Description: "Various healthcare services that can be tailored to your needs"
- Button: "View Services"
```

## Admin Panel Features

### 1. **Index Page**
- ✅ **Language Badge** - Indikator bahasa slider (ID/EN)
- ✅ **Dual Content Display** - Tampilkan konten kedua bahasa
- ✅ **Compact Layout** - Tampilan optimal dengan informasi lengkap
- ✅ **Sortable Table** - Drag & drop untuk urutan

### 2. **Create Page**
- ✅ **Language Selector** - Dropdown pilihan bahasa
- ✅ **Dual Input Fields** - Input untuk kedua bahasa
- ✅ **Real-time Preview** - Preview gambar saat upload
- ✅ **Validation** - Validasi form untuk kedua bahasa

### 3. **Edit Page**
- ✅ **Current Content Display** - Tampilkan konten existing
- ✅ **Dual Language Editing** - Edit konten kedua bahasa
- ✅ **Image Management** - Update gambar dengan preview
- ✅ **Form Validation** - Validasi input untuk kedua bahasa

## Frontend Implementation

### 1. **Language Detection**
```php
// Di PageController
'heroSliders' => HeroSlider::active()
    ->ordered()  // Ambil semua slider aktif (tidak filter bahasa)
    ->get()
```

**Catatan:** Hero slider tidak difilter berdasarkan bahasa karena admin dapat mengatur konten untuk kedua bahasa dalam satu slider.

### 2. **Dynamic Content Display**
```blade
{{-- Hero Section --}}
@if($slider->title)
    <h1>{{ $slider->title }}</h1>
@endif

@if($slider->description)
    <p>{{ $slider->description }}</p>
@endif

@if($slider->button_text)
    <a href="{{ $slider->button_url }}">{{ $slider->button_text }}</a>
@endif
```

**Catatan:** Hero section menggunakan konten dari field bahasa yang sesuai dengan locale website yang aktif.

### 3. **Fallback System**
```blade
{{-- Jika konten bahasa tidak tersedia, gunakan default --}}
@if($slider->localized_title)
    {{ $slider->localized_title }}
@else
    {{ __('messages.heroTitle') }}
@endif
```

## Language Switching

### 1. **Admin Panel**
```
URL: /admin/dashboard?lang=id  (Bahasa Indonesia)
URL: /admin/dashboard?lang=en  (English)
Method: GET parameter
Session: Disimpan di session untuk konsistensi
```

### 2. **Website Utama**
```
URL: /lang/id  (Bahasa Indonesia)
URL: /lang/en  (English)
Method: GET route dengan parameter locale
Session: Disimpan di session untuk konsistensi
Controller: LanguageController@swap
Middleware: SetLocale (otomatis set locale dari session)
```

### 3. **Language Files**
```
lang/id/messages.php  - Bahasa Indonesia
lang/en/messages.php  - English
Config: config/app.php -> locale, fallback_locale, available_locales
```

## Best Practices

### 1. **Content Management**
- ✅ **Konsistensi** - Gunakan tone dan style yang sama
- ✅ **Length Balance** - Jaga keseimbangan panjang teks
- ✅ **Cultural Sensitivity** - Perhatikan konteks budaya
- ✅ **SEO Optimization** - Gunakan keyword yang relevan
- ✅ **Hero Slider Consistency** - Pastikan hero section tetap menggunakan image slider untuk kedua bahasa

### 2. **Translation Quality**
- ✅ **Professional Translation** - Gunakan jasa penerjemah profesional
- ✅ **Context Review** - Review konteks medis
- ✅ **User Testing** - Test dengan native speakers
- ✅ **Regular Updates** - Update konten secara berkala

### 3. **Technical Implementation**
- ✅ **Database Indexing** - Index kolom locale untuk performa
- ✅ **Caching Strategy** - Cache konten berdasarkan bahasa
- ✅ **Error Handling** - Handle kasus bahasa tidak tersedia
- ✅ **Performance Monitoring** - Monitor performa multi-language

## Troubleshooting

### 1. **Konten Tidak Muncul**
```bash
# Check locale setting
php artisan tinker --execute="echo app()->getLocale();"

# Check database content
php artisan tinker --execute="App\Models\HeroSlider::where('locale', 'id')->get();"
```

### 2. **Language Switch Tidak Berfungsi**
```bash
# Clear cache
php artisan config:clear
php artisan route:clear
php artisan view:clear

# Check session
php artisan tinker --execute="echo session('locale');"
```

### 3. **Database Issues**
```bash
# Check migration status
php artisan migrate:status

# Run migrations
php artisan migrate --force
```

## Monitoring & Analytics

### 1. **Language Usage**
- Track bahasa yang paling sering digunakan
- Monitor user preference
- Analyze content engagement per language

### 2. **Performance Metrics**
- Load time per language
- Database query performance
- Cache hit rates

### 3. **Content Quality**
- Translation accuracy
- User feedback per language
- Content update frequency

---

**Version**: 2.0.0 (Multi-Language)  
**Last Updated**: August 2025  
**Maintained By**: Development Team  
**Features**: Dual Language Support, Language Switcher, Dynamic Content
