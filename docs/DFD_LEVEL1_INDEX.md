# DFD Level 1 - Indeks File Draw.io

## Deskripsi
Dokumen ini berisi daftar semua file DFD Level 1 yang tersedia dalam format Draw.io (.drawio).

Setiap proses utama dari DFD Level 0 telah dipecah menjadi sub-proses detail dan disimpan dalam file terpisah untuk kemudahan pengelolaan dan pengeditan.

## Daftar File DFD Level 1

### 1. **DFD_LEVEL1_P1_LOGIN.drawio** ✅
**Proses:** P1.0 Login  
**Sub-proses:**
- P1.1 Masukkan Username & Password
- P1.2 Verifikasi User
- P1.3 Logout

**Data Store:**
- D1 (admin_users)
- D7 (sessions)
- D6 (activity_logs)

---

### 2. **DFD_LEVEL1_P2_MANAJEMEN_DOKTER.drawio** ✅
**Proses:** P2.0 Manajemen Dokter  
**Sub-proses:**
- P2.1 Tambah Data Dokter
- P2.2 Ubah Data Dokter
- P2.3 Hapus Data Dokter
- P2.4 Validasi Data Dokter

**Data Store:**
- D2 (doctors)
- D6 (activity_logs)

**Proses Eksternal:**
- P8.0 Auto-Translation

---

### 3. **DFD_LEVEL1_P3_MANAJEMEN_LAYANAN.drawio** ✅
**Proses:** P3.0 Manajemen Layanan  
**Sub-proses:**
- P3.1 Tambah Data Layanan
- P3.2 Ubah Data Layanan
- P3.3 Hapus Data Layanan
- P3.4 Validasi Data Layanan

**Data Store:**
- D3 (services)
- D6 (activity_logs)

**Proses Eksternal:**
- P8.0 Auto-Translation

---

### 4. **DFD_LEVEL1_P4_MANAJEMEN_FAQ.drawio** ✅
**Proses:** P4.0 Manajemen FAQ  
**Sub-proses:**
- P4.1 Tambah Data FAQ
- P4.2 Ubah Data FAQ
- P4.3 Hapus Data FAQ
- P4.4 Validasi Data FAQ

**Data Store:**
- D4 (faqs)
- D6 (activity_logs)

**Proses Eksternal:**
- P8.0 Auto-Translation

---

### 5. **DFD_LEVEL1_P5_MANAJEMEN_KONTEN.drawio** ✅
**Proses:** P5.0 Manajemen Konten  
**Sub-proses:**
- P5.1 Tambah Data Konten
- P5.2 Ubah Data Konten
- P5.3 Hapus Data Konten
- P5.4 Validasi Data Konten

**Data Store:**
- D5 (content_pages)
- D6 (activity_logs)

**Proses Eksternal:**
- P8.0 Auto-Translation

---

### 6. **DFD_LEVEL1_P6_MANAJEMEN_USER.drawio** ✅
**Proses:** P6.0 Manajemen User (Hanya Super Admin)  
**Sub-proses:**
- P6.1 Tambah Data User Admin
- P6.2 Ubah Data User Admin
- P6.3 Hapus Data User Admin
- P6.4 Validasi Data User Admin

**Data Store:**
- D1 (admin_users)
- D6 (activity_logs)

**Catatan:** Hanya dapat diakses oleh Super Admin

---

### 7. **DFD_LEVEL1_P7_PENGATURAN_AKUN.drawio** ✅
**Proses:** P7.0 Pengaturan Akun  
**Sub-proses:**
- P7.1 Ubah Username
- P7.2 Ubah Password
- P7.3 Validasi Pengaturan Akun

**Data Store:**
- D1 (admin_users)
- D6 (activity_logs)

---

### 8. **DFD_LEVEL1_P8_AUTO_TRANSLATION.drawio** ✅
**Proses:** P8.0 Auto-Translation  
**Sub-proses:**
- P8.1 Terima Teks Bahasa Indonesia
- P8.2 Panggil API Translation
- P8.3 Proses Hasil Terjemahan

**Entitas Eksternal:**
- Google Translate API

---

### 9. **DFD_LEVEL1_P9_TAMPILKAN_WEBSITE.drawio** ✅
**Proses:** P9.0 Tampilkan Website  
**Sub-proses:**
- P9.1 Terima Request Halaman
- P9.2 Baca Data dari Database
- P9.3 Lokalisasi Konten Berdasarkan Bahasa
- P9.4 Render Halaman Website

**Data Store:**
- D2 (doctors)
- D3 (services)
- D4 (faqs)
- D5 (content_pages)
- D7 (sessions)
- D8 (hero_slides)

---

### 10. **DFD_LEVEL1_P10_MANAJEMEN_HERO_SLIDES.drawio** ✅
**Proses:** P10.0 Manajemen Hero Slides  
**Sub-proses:**
- P10.1 Tambah Data Hero Slide
- P10.2 Ubah Data Hero Slide
- P10.3 Hapus Data Hero Slide
- P10.4 Validasi Data Hero Slide

**Data Store:**
- D8 (hero_slides)
- D6 (activity_logs)

**Proses Eksternal:**
- P8.0 Auto-Translation

---

## Cara Membuka File

1. **Online (Recommended):**
   - Kunjungi: https://app.diagrams.net/ atau https://www.draw.io/
   - Klik **"Open Existing Diagram"**
   - Pilih file `.drawio` yang diinginkan dari folder `docs/`

2. **VS Code:**
   - Install extension **"Draw.io Integration"**
   - Klik kanan file `.drawio`
   - Pilih **"Open Preview"**

3. **Desktop App:**
   - Download Draw.io Desktop dari: https://github.com/jgraph/drawio-desktop/releases
   - Install aplikasi
   - Buka aplikasi dan pilih **"Open Existing Diagram"**

## Hubungan dengan DFD Level 0

Semua file DFD Level 1 ini adalah dekomposisi detail dari proses-proses di **DFD_LEVEL0_DRAWIO.drawio**.

**DFD Level 0** menampilkan 10 proses utama:
- P1.0 Login → **DFD_LEVEL1_P1_LOGIN.drawio**
- P2.0 Manajemen Dokter → **DFD_LEVEL1_P2_MANAJEMEN_DOKTER.drawio**
- P3.0 Manajemen Layanan → **DFD_LEVEL1_P3_MANAJEMEN_LAYANAN.drawio**
- P4.0 Manajemen FAQ → **DFD_LEVEL1_P4_MANAJEMEN_FAQ.drawio**
- P5.0 Manajemen Konten → **DFD_LEVEL1_P5_MANAJEMEN_KONTEN.drawio**
- P6.0 Manajemen User → **DFD_LEVEL1_P6_MANAJEMEN_USER.drawio**
- P7.0 Pengaturan Akun → **DFD_LEVEL1_P7_PENGATURAN_AKUN.drawio**
- P8.0 Auto-Translation → **DFD_LEVEL1_P8_AUTO_TRANSLATION.drawio**
- P9.0 Tampilkan Website → **DFD_LEVEL1_P9_TAMPILKAN_WEBSITE.drawio**
- P10.0 Manajemen Hero Slides → **DFD_LEVEL1_P10_MANAJEMEN_HERO_SLIDES.drawio**

## Catatan Penting

1. Semua file menggunakan format Draw.io (diagrams.net) yang dapat diedit langsung
2. Setiap file dapat diekspor ke berbagai format: PNG, SVG, PDF, dll
3. File dapat dibuka di berbagai platform (online, desktop, VS Code)
4. Struktur dasar sudah dibuat, dapat ditambahkan detail lebih lanjut sesuai kebutuhan

---

**Versi:** 1.0  
**Tanggal:** 2025-01-14  
**Format:** Draw.io (diagrams.net)  
**Status:** Complete

