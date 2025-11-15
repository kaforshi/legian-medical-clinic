# DFD Level 0 - Sistem Website Legian Medical Clinic

## Deskripsi
DFD Level 0 (Data Flow Diagram Level 0) menggambarkan proses-proses utama dalam sistem dan alur data antara proses, entitas eksternal, dan data store.

**Catatan Simbol:**
- **Proses:** Lingkaran dengan label P1.0, P2.0, dst.
- **Data Store:** Dua garis horizontal paralel (open-ended rectangle) dengan label D1, D2, dst. - direpresentasikan sebagai persegi panjang dengan border tebal di bagian atas dan bawah.
- **Entitas Eksternal:** Kotak dengan label nama entitas.

## DFD Level 0

```plantuml
@startuml DFD Level 0
!theme plain
skinparam linetype ortho
skinparam roundcorner 10

' External Entities
actor "Super Admin" as SuperAdmin #ffebee
actor "Admin" as Admin #fff3e0
actor "Pengunjung Website" as Visitor #f3e5f5
cloud "Google Translate API" as GoogleAPI #e8f5e9

' Processes (circles in DFD)
circle "P1.0\nLogin" as P1 #e3f2fd
circle "P2.0\nManajemen\nDokter" as P2 #e3f2fd
circle "P3.0\nManajemen\nLayanan" as P3 #e3f2fd
circle "P4.0\nManajemen\nFAQ" as P4 #e3f2fd
circle "P5.0\nManajemen\nKonten" as P5 #e3f2fd
circle "P6.0\nManajemen\nUser" as P6 #e3f2fd
circle "P7.0\nPengaturan\nAkun" as P7 #e3f2fd
circle "P8.0\nAuto-\nTranslation" as P8 #e3f2fd
circle "P9.0\nTampilkan\nWebsite" as P9 #e3f2fd
circle "P10.0\nManajemen\nHero Slides" as P10 #e3f2fd

' Data Stores (database notation)
database "D1\nadmin_users" as D1 #fff9c4
database "D2\ndoctors" as D2 #fff9c4
database "D3\nservices" as D3 #fff9c4
database "D4\nfaqs" as D4 #fff9c4
database "D5\ncontent_pages" as D5 #fff9c4
database "D6\nactivity_logs" as D6 #fff9c4
database "D7\nsessions" as D7 #fff9c4
database "D8\nhero_slides" as D8 #fff9c4

' P1.0 Login Flows
SuperAdmin --> P1 : data login super admin
P1 --> SuperAdmin : info login
Admin --> P1 : data login admin
P1 --> Admin : info login
P1 <--> D1 : data login
P1 --> D7 : data session
P1 --> D6 : data log aktivitas

' P2.0 Manajemen Dokter Flows
SuperAdmin --> P2 : data dokter
P2 --> SuperAdmin : info dokter
Admin --> P2 : data dokter
P2 --> Admin : info dokter
P2 <--> D2 : data dokter
P2 --> D6 : data log aktivitas

' P3.0 Manajemen Layanan Flows
SuperAdmin --> P3 : data layanan
P3 --> SuperAdmin : info layanan
Admin --> P3 : data layanan
P3 --> Admin : info layanan
P3 <--> D3 : data layanan
P3 --> D6 : data log aktivitas
P3 --> P8 : data teks bahasa Indonesia

' P4.0 Manajemen FAQ Flows
SuperAdmin --> P4 : data FAQ
P4 --> SuperAdmin : info FAQ
Admin --> P4 : data FAQ
P4 --> Admin : info FAQ
P4 <--> D4 : data FAQ
P4 --> D6 : data log aktivitas
P4 --> P8 : data teks bahasa Indonesia

' P5.0 Manajemen Konten Flows
SuperAdmin --> P5 : data konten halaman
P5 --> SuperAdmin : info konten halaman
Admin --> P5 : data konten halaman
P5 --> Admin : info konten halaman
P5 <--> D5 : data konten halaman
P5 --> D6 : data log aktivitas
P5 --> P8 : data teks bahasa Indonesia

' P6.0 Manajemen User Flows (Super Admin only)
SuperAdmin --> P6 : data user admin
P6 --> SuperAdmin : info user admin
P6 <--> D1 : data user admin
P6 --> D6 : data log aktivitas

' P7.0 Pengaturan Akun Flows
SuperAdmin --> P7 : data pengaturan akun
P7 --> SuperAdmin : info pengaturan akun
Admin --> P7 : data pengaturan akun
P7 --> Admin : info pengaturan akun
P7 <--> D1 : data admin user
P7 --> D6 : data log aktivitas

' P8.0 Auto-Translation Flows
P8 --> GoogleAPI : data teks bahasa Indonesia
GoogleAPI --> P8 : info teks terjemahan
P8 --> P2 : info teks terjemahan
P8 --> P3 : info teks terjemahan
P8 --> P4 : info teks terjemahan
P8 --> P5 : info teks terjemahan
P8 --> P10 : info teks terjemahan

' P9.0 Tampilkan Website Flows
Visitor --> P9 : data request halaman
Visitor --> P9 : data pilihan bahasa
Visitor --> P9 : data response kuesioner
P9 --> Visitor : info konten website
P9 --> Visitor : info dokter
P9 --> Visitor : info layanan
P9 --> Visitor : info FAQ
P9 --> Visitor : info konten halaman
P9 --> Visitor : info hero slide
P9 --> Visitor : info layout prioritas
P9 --> D2 : data request
P9 --> D3 : data request
P9 --> D4 : data request
P9 --> D5 : data request
P9 --> D8 : data request
P9 <--> D7 : data session

' P10.0 Manajemen Hero Slides Flows
SuperAdmin --> P10 : data hero slide
P10 --> SuperAdmin : info hero slide
Admin --> P10 : data hero slide
P10 --> Admin : info hero slide
P10 <--> D8 : data hero slide
P10 --> D6 : data log aktivitas
P10 --> P8 : data teks bahasa Indonesia

@enduml
```

## Proses-Proses Utama

### P1.0 Login
**Deskripsi:** Proses autentikasi untuk Super Admin dan Admin.

**Input:**
- `data login super admin` dari Super Admin
- `data login admin` dari Admin

**Output:**
- `info login` ke Super Admin/Admin
- `data session` ke D7 (sessions)
- `data log aktivitas` ke D6 (activity_logs)

**Data Store:**
- D1 (admin_users) - membaca dan menulis data login

---

### P2.0 Manajemen Dokter
**Deskripsi:** Proses CRUD untuk mengelola data dokter.

**Input:**
- `data dokter` dari Super Admin/Admin
- `info teks terjemahan` dari P8.0 (Auto-Translation)

**Output:**
- `info dokter` ke Super Admin/Admin
- `data log aktivitas` ke D6 (activity_logs)
- `data teks bahasa Indonesia` ke P8.0 (untuk auto-translation)

**Data Store:**
- D2 (doctors) - membaca dan menulis data dokter

---

### P3.0 Manajemen Layanan
**Deskripsi:** Proses CRUD untuk mengelola data layanan medis.

**Input:**
- `data layanan` dari Super Admin/Admin
- `info teks terjemahan` dari P8.0 (Auto-Translation)

**Output:**
- `info layanan` ke Super Admin/Admin
- `data log aktivitas` ke D6 (activity_logs)
- `data teks bahasa Indonesia` ke P8.0 (untuk auto-translation)

**Data Store:**
- D3 (services) - membaca dan menulis data layanan

---

### P4.0 Manajemen FAQ
**Deskripsi:** Proses CRUD untuk mengelola data FAQ.

**Input:**
- `data FAQ` dari Super Admin/Admin
- `info teks terjemahan` dari P8.0 (Auto-Translation)

**Output:**
- `info FAQ` ke Super Admin/Admin
- `data log aktivitas` ke D6 (activity_logs)
- `data teks bahasa Indonesia` ke P8.0 (untuk auto-translation)

**Data Store:**
- D4 (faqs) - membaca dan menulis data FAQ

---

### P5.0 Manajemen Konten
**Deskripsi:** Proses CRUD untuk mengelola konten halaman (Tentang Kami, Kontak, dll).

**Input:**
- `data konten halaman` dari Super Admin/Admin
- `info teks terjemahan` dari P8.0 (Auto-Translation)

**Output:**
- `info konten halaman` ke Super Admin/Admin
- `data log aktivitas` ke D6 (activity_logs)
- `data teks bahasa Indonesia` ke P8.0 (untuk auto-translation)

**Data Store:**
- D5 (content_pages) - membaca dan menulis data konten

---

### P6.0 Manajemen User
**Deskripsi:** Proses CRUD untuk mengelola user admin (hanya Super Admin).

**Input:**
- `data user admin` dari Super Admin

**Output:**
- `info user admin` ke Super Admin
- `data log aktivitas` ke D6 (activity_logs)

**Data Store:**
- D1 (admin_users) - membaca dan menulis data user admin

---

### P7.0 Pengaturan Akun
**Deskripsi:** Proses untuk mengubah username dan password akun yang sedang login.

**Input:**
- `data pengaturan akun` dari Super Admin/Admin

**Output:**
- `info pengaturan akun` ke Super Admin/Admin
- `data log aktivitas` ke D6 (activity_logs)

**Data Store:**
- D1 (admin_users) - membaca dan menulis data admin user

---

### P8.0 Auto-Translation
**Deskripsi:** Proses untuk menerjemahkan teks bahasa Indonesia ke bahasa Inggris secara otomatis.

**Input:**
- `data teks bahasa Indonesia` dari P2.0, P3.0, P4.0, P5.0
- `info teks terjemahan` dari Google Translate API

**Output:**
- `info teks terjemahan` ke P2.0, P3.0, P4.0, P5.0
- `data teks bahasa Indonesia` ke Google Translate API

**External Entity:**
- Google Translate API

---

### P9.0 Tampilkan Website
**Deskripsi:** Proses untuk menampilkan konten website kepada pengunjung.

**Input:**
- `data request halaman` dari Pengunjung Website
- `data pilihan bahasa` dari Pengunjung Website
- `data response kuesioner` dari Pengunjung Website

**Output:**
- `info konten website` ke Pengunjung Website
- `info dokter` ke Pengunjung Website
- `info layanan` ke Pengunjung Website
- `info FAQ` ke Pengunjung Website
- `info konten halaman` ke Pengunjung Website
- `info hero slide` ke Pengunjung Website
- `info layout prioritas` ke Pengunjung Website

**Data Store:**
- D2 (doctors) - membaca data dokter
- D3 (services) - membaca data layanan
- D4 (faqs) - membaca data FAQ
- D5 (content_pages) - membaca data konten
- D8 (hero_slides) - membaca data hero slides
- D7 (sessions) - membaca dan menulis data session

---

### P10.0 Manajemen Hero Slides
**Deskripsi:** Proses CRUD untuk mengelola data hero slides.

**Input:**
- `data hero slide` dari Super Admin/Admin
- `info teks terjemahan` dari P8.0 (Auto-Translation)

**Output:**
- `info hero slide` ke Super Admin/Admin
- `data log aktivitas` ke D6 (activity_logs)
- `data teks bahasa Indonesia` ke P8.0 (untuk auto-translation)

**Data Store:**
- D8 (hero_slides) - membaca dan menulis data hero slides

---

## Data Store

### D1. admin_users
**Deskripsi:** Menyimpan data admin user (Super Admin dan Admin).

**Digunakan oleh:**
- P1.0 (Login) - membaca dan menulis
- P6.0 (Manajemen User) - membaca dan menulis
- P7.0 (Pengaturan Akun) - membaca dan menulis

---

### D2. doctors
**Deskripsi:** Menyimpan data dokter.

**Digunakan oleh:**
- P2.0 (Manajemen Dokter) - membaca dan menulis
- P9.0 (Tampilkan Website) - membaca

---

### D3. services
**Deskripsi:** Menyimpan data layanan medis.

**Digunakan oleh:**
- P3.0 (Manajemen Layanan) - membaca dan menulis
- P9.0 (Tampilkan Website) - membaca

---

### D4. faqs
**Deskripsi:** Menyimpan data FAQ.

**Digunakan oleh:**
- P4.0 (Manajemen FAQ) - membaca dan menulis
- P9.0 (Tampilkan Website) - membaca

---

### D5. content_pages
**Deskripsi:** Menyimpan konten halaman (Tentang Kami, Kontak, dll).

**Digunakan oleh:**
- P5.0 (Manajemen Konten) - membaca dan menulis
- P9.0 (Tampilkan Website) - membaca

---

### D6. activity_logs
**Deskripsi:** Menyimpan log aktivitas admin.

**Digunakan oleh:**
- P1.0 (Login) - menulis
- P2.0 (Manajemen Dokter) - menulis
- P3.0 (Manajemen Layanan) - menulis
- P4.0 (Manajemen FAQ) - menulis
- P5.0 (Manajemen Konten) - menulis
- P6.0 (Manajemen User) - menulis
- P7.0 (Pengaturan Akun) - menulis

---

### D7. sessions
**Deskripsi:** Menyimpan data session untuk autentikasi dan lokalisasi bahasa.

**Digunakan oleh:**
- P1.0 (Login) - menulis
- P9.0 (Tampilkan Website) - membaca dan menulis

---

### D8. hero_slides
**Deskripsi:** Menyimpan data hero slides untuk homepage.

**Digunakan oleh:**
- P10.0 (Manajemen Hero Slides) - membaca dan menulis
- P9.0 (Tampilkan Website) - membaca

---

## Catatan Penting

1. **P6.0 Manajemen User** hanya dapat diakses oleh Super Admin
2. **P8.0 Auto-Translation** bekerja secara otomatis saat admin menyimpan data dalam bahasa Indonesia
3. **P9.0 Tampilkan Website** membaca data dari multiple data stores untuk menampilkan konten yang dilokalisasi
4. Semua proses manajemen (P2-P5, P10) mencatat aktivitas ke D6 (activity_logs)
5. P2, P3, P4, P5, P10 mengirim data ke P8 untuk auto-translation sebelum menyimpan ke database

---

**Versi:** 1.0  
**Tanggal:** 2025-01-14  
**Status:** Current

