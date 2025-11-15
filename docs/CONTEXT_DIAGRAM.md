# Diagram Konteks Sistem - Legian Medical Clinic

## Deskripsi
Diagram konteks (Context Diagram / DFD Level 0) menggambarkan sistem secara keseluruhan dan interaksinya dengan entitas eksternal.

## Diagram Konteks

```plantuml
@startuml Context Diagram
!theme plain
skinparam componentStyle rectangle
skinparam linetype ortho

rectangle "Sistem Website\nLegian Medical Clinic" as System #e1f5ff

actor "Super Admin" as SuperAdmin #ffebee
actor "Admin" as Admin #fff3e0
actor "Pengunjung Website" as Visitor #f3e5f5
cloud "Google Translate API" as GoogleAPI #e8f5e9

' Super Admin Input Flows
SuperAdmin --> System : data login super admin
SuperAdmin --> System : data dokter
SuperAdmin --> System : data layanan
SuperAdmin --> System : data FAQ
SuperAdmin --> System : data konten halaman
SuperAdmin --> System : data hero slide
SuperAdmin --> System : data user admin
SuperAdmin --> System : data pengaturan akun

' Super Admin Output Flows
System --> SuperAdmin : info login
System --> SuperAdmin : info dokter
System --> SuperAdmin : info layanan
System --> SuperAdmin : info FAQ
System --> SuperAdmin : info konten halaman
System --> SuperAdmin : info hero slide
System --> SuperAdmin : info user admin
System --> SuperAdmin : info dashboard
System --> SuperAdmin : info log aktivitas

' Admin Input Flows
Admin --> System : data login admin
Admin --> System : data dokter
Admin --> System : data layanan
Admin --> System : data FAQ
Admin --> System : data konten halaman
Admin --> System : data hero slide
Admin --> System : data pengaturan akun

' Admin Output Flows
System --> Admin : info login
System --> Admin : info dokter
System --> Admin : info layanan
System --> Admin : info FAQ
System --> Admin : info konten halaman
System --> Admin : info hero slide
System --> Admin : info dashboard
System --> Admin : info log aktivitas

' Visitor Input Flows
Visitor --> System : data request halaman
Visitor --> System : data pilihan bahasa
Visitor --> System : data response kuesioner

' Visitor Output Flows
System --> Visitor : info konten website
System --> Visitor : info dokter
System --> Visitor : info layanan
System --> Visitor : info FAQ
System --> Visitor : info konten halaman
System --> Visitor : info hero slide
System --> Visitor : info layout prioritas

' Google API Flows
System --> GoogleAPI : data teks bahasa Indonesia
GoogleAPI --> System : info teks terjemahan

@enduml
```

## Entitas Eksternal

### 1. Super Admin
**Deskripsi:** Pengguna dengan akses penuh ke admin panel, termasuk manajemen user admin.

**Aktivitas:**
- Login ke admin panel
- Mengelola data dokter (CRUD)
- Mengelola layanan medis (CRUD)
- Mengelola FAQ (CRUD)
- Mengelola halaman konten (Tentang Kami, Kontak, dll)
- Mengelola hero slides (CRUD)
- Mengelola user admin (CRUD) - **hanya Super Admin**
- Mengatur akun sendiri (ubah username/password)
- Melihat dashboard dan log aktivitas

**Alur Data:**
- Input: Kredensial login, data CRUD (dokter, layanan, FAQ, konten, hero slide, user admin)
- Output: Dashboard, konfirmasi operasi, data yang dikelola, info user admin

### 2. Admin
**Deskripsi:** Pengguna dengan akses terbatas ke admin panel, tidak dapat mengelola user admin.

**Aktivitas:**
- Login ke admin panel
- Mengelola data dokter (CRUD)
- Mengelola layanan medis (CRUD)
- Mengelola FAQ (CRUD)
- Mengelola halaman konten (Tentang Kami, Kontak, dll)
- Mengelola hero slides (CRUD)
- Mengatur akun sendiri (ubah username/password)
- Melihat dashboard dan log aktivitas

**Alur Data:**
- Input: Kredensial login, data CRUD (dokter, layanan, FAQ, konten, hero slide)
- Output: Dashboard, konfirmasi operasi, data yang dikelola

### 3. Pengunjung Website (Public Visitor)
**Deskripsi:** Pengunjung yang mengakses website publik untuk melihat informasi klinik.

**Aktivitas:**
- Melihat halaman utama website
- Melihat informasi dokter
- Melihat layanan medis
- Melihat FAQ
- Melihat konten halaman (Tentang Kami, Kontak)
- Melihat hero slides
- Mengganti bahasa (Indonesia/Inggris)
- Mengisi kuesioner preferensi section

**Alur Data:**
- Input: Request halaman, pilihan bahasa, response kuesioner
- Output: Konten website yang dilokalisasi sesuai bahasa

### 4. Google Translate API (Layanan Eksternal)
**Deskripsi:** Layanan eksternal untuk auto-translation dari bahasa Indonesia ke bahasa Inggris.

**Aktivitas:**
- Menerima request terjemahan
- Mengembalikan teks yang sudah diterjemahkan

**Alur Data:**
- Input: Teks bahasa Indonesia
- Output: Teks bahasa Inggris

## Sistem Utama

### Sistem Website Legian Medical Clinic
**Deskripsi:** Sistem website untuk klinik medis yang terdiri dari:
- Website publik (frontend) untuk menampilkan informasi
- Admin panel (backend) untuk mengelola konten
- Layanan auto-translation untuk dukungan multi-bahasa

**Fitur Utama:**
1. **Website Publik:**
   - Menampilkan informasi dokter, layanan, FAQ, konten halaman, dan hero slides
   - Dukungan multi-bahasa (Indonesia/Inggris)
   - Prioritisasi konten dinamis berdasarkan kuesioner

2. **Admin Panel:**
   - Autentikasi & Otorisasi (Admin/Super Admin)
   - Operasi CRUD untuk semua konten
   - Manajemen user (hanya Super Admin)
   - Pengaturan akun
   - Pencatatan aktivitas

3. **Auto-Translation:**
   - Otomatis menerjemahkan konten dari bahasa Indonesia ke bahasa Inggris
   - Menggunakan Google Translate API

## Penyimpanan Data (Internal)

Sistem menggunakan database untuk menyimpan:
- `admin_users` - Data admin user
- `doctors` - Data dokter
- `services` - Data layanan medis
- `faqs` - Data FAQ
- `content_pages` - Konten halaman (Tentang Kami, Kontak, dll)
- `hero_slides` - Data hero slides untuk homepage
- `activity_logs` - Log aktivitas admin
- `sessions` - Data session

## Catatan Penting

1. **Autentikasi:** Admin harus login terlebih dahulu sebelum mengakses admin panel
2. **Otorisasi:** Super Admin memiliki akses penuh, Admin memiliki akses terbatas
3. **Auto-Translation:** Hanya admin yang input bahasa Indonesia, sistem otomatis translate ke bahasa Inggris
4. **Lokalisasi:** Website publik menampilkan konten sesuai bahasa yang dipilih pengunjung
5. **Pencatatan Aktivitas:** Semua aktivitas admin dicatat untuk audit trail

---

**Versi:** 1.0  
**Tanggal:** 2025-01-14  
**Status:** Current

