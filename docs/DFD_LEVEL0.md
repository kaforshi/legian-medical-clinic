# DFD Level 0 - Sistem Website Legian Medical Clinic

## Deskripsi
DFD Level 0 (Data Flow Diagram Level 0) menggambarkan proses-proses utama dalam sistem dan alur data antara proses, entitas eksternal, dan data store.

**Catatan Simbol:**
- **Proses:** Lingkaran dengan label P1.0, P2.0, dst.
- **Data Store:** Dua garis horizontal paralel (open-ended rectangle) dengan label D1, D2, dst. - direpresentasikan sebagai persegi panjang dengan border tebal di bagian atas dan bawah.
- **Entitas Eksternal:** Kotak dengan label nama entitas.

## DFD Level 0

```mermaid
graph TB
    %% External Entities
    SuperAdmin["Super Admin"]
    Admin["Admin"]
    Visitor["Pengunjung Website"]
    GoogleAPI["Google Translate API"]
    
    %% Processes
    P1["P1.0<br/>Login"]
    P2["P2.0<br/>Manajemen Dokter"]
    P3["P3.0<br/>Manajemen Layanan"]
    P4["P4.0<br/>Manajemen FAQ"]
    P5["P5.0<br/>Manajemen Konten"]
    P6["P6.0<br/>Manajemen User"]
    P7["P7.0<br/>Pengaturan Akun"]
    P8["P8.0<br/>Auto-Translation"]
    P9["P9.0<br/>Tampilkan Website"]
    
    %% Data Stores (DFD notation: two parallel horizontal lines)
    D1["D1<br/>admin_users"]
    D2["D2<br/>doctors"]
    D3["D3<br/>services"]
    D4["D4<br/>faqs"]
    D5["D5<br/>content_pages"]
    D6["D6<br/>activity_logs"]
    D7["D7<br/>sessions"]
    
    %% P1.0 Login Flows
    SuperAdmin -->|"data login super admin"| P1
    P1 -->|"info login"| SuperAdmin
    Admin -->|"data login admin"| P1
    P1 -->|"info login"| Admin
    P1 <-->|"data login"| D1
    P1 -->|"data session"| D7
    P1 -->|"data log aktivitas"| D6
    
    %% P2.0 Manajemen Dokter Flows
    SuperAdmin -->|"data dokter"| P2
    P2 -->|"info dokter"| SuperAdmin
    Admin -->|"data dokter"| P2
    P2 -->|"info dokter"| Admin
    P2 <-->|"data dokter"| D2
    P2 -->|"data log aktivitas"| D6
    
    %% P3.0 Manajemen Layanan Flows
    SuperAdmin -->|"data layanan"| P3
    P3 -->|"info layanan"| SuperAdmin
    Admin -->|"data layanan"| P3
    P3 -->|"info layanan"| Admin
    P3 <-->|"data layanan"| D3
    P3 -->|"data log aktivitas"| D6
    P3 -->|"data teks bahasa Indonesia"| P8
    
    %% P4.0 Manajemen FAQ Flows
    SuperAdmin -->|"data FAQ"| P4
    P4 -->|"info FAQ"| SuperAdmin
    Admin -->|"data FAQ"| P4
    P4 -->|"info FAQ"| Admin
    P4 <-->|"data FAQ"| D4
    P4 -->|"data log aktivitas"| D6
    P4 -->|"data teks bahasa Indonesia"| P8
    
    %% P5.0 Manajemen Konten Flows
    SuperAdmin -->|"data konten halaman"| P5
    P5 -->|"info konten halaman"| SuperAdmin
    Admin -->|"data konten halaman"| P5
    P5 -->|"info konten halaman"| Admin
    P5 <-->|"data konten halaman"| D5
    P5 -->|"data log aktivitas"| D6
    P5 -->|"data teks bahasa Indonesia"| P8
    
    %% P6.0 Manajemen User Flows (Super Admin only)
    SuperAdmin -->|"data user admin"| P6
    P6 -->|"info user admin"| SuperAdmin
    P6 <-->|"data user admin"| D1
    P6 -->|"data log aktivitas"| D6
    
    %% P7.0 Pengaturan Akun Flows
    SuperAdmin -->|"data pengaturan akun"| P7
    P7 -->|"info pengaturan akun"| SuperAdmin
    Admin -->|"data pengaturan akun"| P7
    P7 -->|"info pengaturan akun"| Admin
    P7 <-->|"data admin user"| D1
    P7 -->|"data log aktivitas"| D6
    
    %% P8.0 Auto-Translation Flows
    P8 -->|"data teks bahasa Indonesia"| GoogleAPI
    GoogleAPI -->|"info teks terjemahan"| P8
    P8 -->|"info teks terjemahan"| P3
    P8 -->|"info teks terjemahan"| P4
    P8 -->|"info teks terjemahan"| P5
    P8 -->|"info teks terjemahan"| P2
    
    %% P9.0 Tampilkan Website Flows
    Visitor -->|"data request halaman"| P9
    Visitor -->|"data pilihan bahasa"| P9
    Visitor -->|"data response kuesioner"| P9
    P9 -->|"info konten website"| Visitor
    P9 -->|"info dokter"| Visitor
    P9 -->|"info layanan"| Visitor
    P9 -->|"info FAQ"| Visitor
    P9 -->|"info konten halaman"| Visitor
    P9 -->|"info layout prioritas"| Visitor
    P9 -->|"data request"| D2
    P9 -->|"data request"| D3
    P9 -->|"data request"| D4
    P9 -->|"data request"| D5
    P9 <-->|"data session"| D7
    
    style P1 fill:#e3f2fd,stroke:#1976d2,stroke-width:2px
    style P2 fill:#e3f2fd,stroke:#1976d2,stroke-width:2px
    style P3 fill:#e3f2fd,stroke:#1976d2,stroke-width:2px
    style P4 fill:#e3f2fd,stroke:#1976d2,stroke-width:2px
    style P5 fill:#e3f2fd,stroke:#1976d2,stroke-width:2px
    style P6 fill:#e3f2fd,stroke:#1976d2,stroke-width:2px
    style P7 fill:#e3f2fd,stroke:#1976d2,stroke-width:2px
    style P8 fill:#e3f2fd,stroke:#1976d2,stroke-width:2px
    style P9 fill:#e3f2fd,stroke:#1976d2,stroke-width:2px
    style SuperAdmin fill:#ffebee,stroke:#c62828,stroke-width:2px
    style Admin fill:#fff3e0,stroke:#e65100,stroke-width:2px
    style Visitor fill:#f3e5f5,stroke:#4a148c,stroke-width:2px
    style GoogleAPI fill:#e8f5e9,stroke:#1b5e20,stroke-width:2px
    style D1 fill:#fff9c4,stroke:#f57f17,stroke-width:4px
    style D2 fill:#fff9c4,stroke:#f57f17,stroke-width:4px
    style D3 fill:#fff9c4,stroke:#f57f17,stroke-width:4px
    style D4 fill:#fff9c4,stroke:#f57f17,stroke-width:4px
    style D5 fill:#fff9c4,stroke:#f57f17,stroke-width:4px
    style D6 fill:#fff9c4,stroke:#f57f17,stroke-width:4px
    style D7 fill:#fff9c4,stroke:#f57f17,stroke-width:4px
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
- `info layout prioritas` ke Pengunjung Website

**Data Store:**
- D2 (doctors) - membaca data dokter
- D3 (services) - membaca data layanan
- D4 (faqs) - membaca data FAQ
- D5 (content_pages) - membaca data konten
- D7 (sessions) - membaca dan menulis data session

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

## Catatan Penting

1. **P6.0 Manajemen User** hanya dapat diakses oleh Super Admin
2. **P8.0 Auto-Translation** bekerja secara otomatis saat admin menyimpan data dalam bahasa Indonesia
3. **P9.0 Tampilkan Website** membaca data dari multiple data stores untuk menampilkan konten yang dilokalisasi
4. Semua proses manajemen (P2-P7) mencatat aktivitas ke D6 (activity_logs)
5. P2, P3, P4, P5 mengirim data ke P8 untuk auto-translation sebelum menyimpan ke database

---

**Versi:** 1.0  
**Tanggal:** 2025-01-14  
**Status:** Current

