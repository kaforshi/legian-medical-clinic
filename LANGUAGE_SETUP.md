# Fitur Ganti Bahasa - Legian Medical Clinic

## Overview
Website Legian Medical Clinic mendukung fitur ganti bahasa antara Bahasa Indonesia dan Bahasa Inggris.

## Fitur yang Tersedia
- **Bahasa Indonesia (ID)**: Bahasa utama untuk pengguna lokal
- **Bahasa Inggris (EN)**: Bahasa internasional untuk wisatawan

## Cara Kerja
1. **Language Switcher**: Dropdown di navbar untuk memilih bahasa
2. **Session Storage**: Bahasa yang dipilih disimpan dalam session
3. **Middleware**: Localization middleware mengatur bahasa aplikasi
4. **Translation Files**: File bahasa tersimpan di `resources/lang/`

## Struktur File
```
resources/lang/
├── en/
│   └── messages.php    # File bahasa Inggris
└── id/
    └── messages.php    # File bahasa Indonesia

app/Http/
├── Controllers/
│   └── LanguageController.php    # Controller untuk ganti bahasa
└── Middleware/
    └── Localization.php          # Middleware untuk set locale

routes/
└── web.php                       # Route untuk ganti bahasa

bootstrap/
└── app.php                       # Konfigurasi middleware
```

## Cara Penggunaan
1. **Buka Website**: Akses website Legian Medical Clinic
2. **Pilih Bahasa**: Klik dropdown language switcher di navbar
3. **Pilih Bahasa**: Pilih "Indonesia (ID)" atau "English (EN)"
4. **Konfirmasi**: Website akan reload dengan bahasa yang dipilih

## Testing
Untuk memverifikasi fitur ganti bahasa berfungsi:
1. Akses `/test-locale` untuk melihat status locale
2. Gunakan tombol "Switch to English" atau "Switch to Indonesian"
3. Periksa apakah konten berubah sesuai bahasa

## Troubleshooting
Jika fitur ganti bahasa tidak berfungsi:

1. **Periksa Session**: Pastikan session berfungsi dengan baik
2. **Periksa Middleware**: Pastikan Localization middleware terdaftar
3. **Periksa Routes**: Pastikan route `lang/{locale}` tersedia
4. **Periksa Files**: Pastikan file bahasa ada dan valid

## Logs
Fitur ganti bahasa akan mencatat log:
- **Info**: Ketika bahasa berhasil diganti
- **Warning**: Ketika ada locale yang tidak valid
- **Debug**: Ketika locale diatur dari session atau default

## Konfigurasi
- **Default Locale**: English (en)
- **Fallback Locale**: English (en)
- **Available Locales**: ['en', 'id']
- **Session Key**: 'locale'

## Dependencies
- Laravel Framework
- Bootstrap CSS/JS
- Session Management
- Translation System
