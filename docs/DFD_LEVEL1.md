# DFD Level 1 - Sistem Website Legian Medical Clinic

## Deskripsi
DFD Level 1 (Data Flow Diagram Level 1) adalah dekomposisi dari setiap proses di DFD Level 0 menjadi sub-proses yang lebih detail. Setiap proses utama (P1.0, P2.0, dst.) dipecah menjadi proses-proses spesifik yang menggambarkan langkah-langkah detail dalam sistem.

**Catatan Simbol:**
- **Proses:** Lingkaran dengan label P1.1, P1.2, P2.1, dst. (sub-proses dari proses utama)
- **Data Store:** Dua garis horizontal paralel dengan label D1, D2, dst.
- **Entitas Eksternal:** Kotak dengan label nama entitas.

## DFD Level 1

### P1.0 Login

```mermaid
graph TB
    %% External Entities
    SuperAdmin["Super Admin"]
    Admin["Admin"]
    
    %% Sub-processes
    P11["P1.1<br/>Masukkan<br/>Username &<br/>Password"]
    P12["P1.2<br/>Verifikasi<br/>User"]
    P13["P1.3<br/>Logout"]
    
    %% Data Stores
    D1["D1<br/>admin_users"]
    D7["D7<br/>sessions"]
    D6["D6<br/>activity_logs"]
    
    %% Flows - Login
    SuperAdmin -->|"login"| P11
    Admin -->|"login"| P11
    P11 -->|"data username & password"| P12
    P12 <-->|"data login"| D1
    P12 -->|"data session"| D7
    P12 -->|"data log aktivitas"| D6
    P12 -->|"pesan login berhasil atau gagal"| SuperAdmin
    P12 -->|"pesan login berhasil atau gagal"| Admin
    
    %% Flows - Logout
    SuperAdmin -->|"request logout"| P13
    Admin -->|"request logout"| P13
    P13 -->|"hapus session"| D7
    P13 -->|"data log aktivitas"| D6
    P13 -->|"konfirmasi logout"| SuperAdmin
    P13 -->|"konfirmasi logout"| Admin
    
    style P11 fill:#e3f2fd,stroke:#1976d2,stroke-width:2px
    style P12 fill:#e3f2fd,stroke:#1976d2,stroke-width:2px
    style P13 fill:#e3f2fd,stroke:#1976d2,stroke-width:2px
    style SuperAdmin fill:#ffebee,stroke:#c62828,stroke-width:2px
    style Admin fill:#fff3e0,stroke:#e65100,stroke-width:2px
    style D1 fill:#fff9c4,stroke:#f57f17,stroke-width:4px
    style D7 fill:#fff9c4,stroke:#f57f17,stroke-width:4px
    style D6 fill:#fff9c4,stroke:#f57f17,stroke-width:4px
```

---

### P2.0 Manajemen Dokter

```mermaid
graph TB
    %% External Entities
    SuperAdmin["Super Admin"]
    Admin["Admin"]
    
    %% Sub-processes
    P21["P2.1<br/>Tambah Data<br/>Dokter"]
    P22["P2.2<br/>Ubah Data<br/>Dokter"]
    P23["P2.3<br/>Hapus Data<br/>Dokter"]
    P24["P2.4<br/>Validasi Data<br/>Dokter"]
    
    %% Data Stores
    D2["D2<br/>doctors"]
    D6["D6<br/>activity_logs"]
    
    %% External Process
    P8["P8.0<br/>Auto-Translation"]
    
    %% Flows from External Entities
    SuperAdmin -->|"info data dokter"| P21
    SuperAdmin -->|"info data dokter"| P22
    SuperAdmin -->|"info data dokter"| P23
    Admin -->|"info data dokter"| P21
    Admin -->|"info data dokter"| P22
    Admin -->|"info data dokter"| P23
    
    %% Flows between processes
    P21 -->|"info data dokter"| P24
    P22 -->|"info data dokter"| P24
    P23 -->|"info data dokter"| P24
    P24 -->|"data dokter update"| P21
    P24 -->|"data dokter update"| P22
    P24 -->|"data dokter update"| P23
    
    %% Flows to Data Store
    P24 -->|"info data dokter"| D2
    D2 -->|"data dokter update"| P24
    
    %% Flows to Activity Log
    P24 -->|"data log aktivitas"| D6
    
    %% Flows to Auto-Translation
    P24 -->|"data teks bahasa Indonesia"| P8
    P8 -->|"info teks terjemahan"| P24
    
    %% Flows back to External Entities
    P21 -->|"data dokter update"| SuperAdmin
    P21 -->|"data dokter update"| Admin
    P22 -->|"data dokter update"| SuperAdmin
    P22 -->|"data dokter update"| Admin
    P23 -->|"data dokter update"| SuperAdmin
    P23 -->|"data dokter update"| Admin
    P24 -->|"data dokter update"| SuperAdmin
    P24 -->|"data dokter update"| Admin
    
    style P21 fill:#e3f2fd,stroke:#1976d2,stroke-width:2px
    style P22 fill:#e3f2fd,stroke:#1976d2,stroke-width:2px
    style P23 fill:#e3f2fd,stroke:#1976d2,stroke-width:2px
    style P24 fill:#e3f2fd,stroke:#1976d2,stroke-width:2px
    style SuperAdmin fill:#ffebee,stroke:#c62828,stroke-width:2px
    style Admin fill:#fff3e0,stroke:#e65100,stroke-width:2px
    style D2 fill:#fff9c4,stroke:#f57f17,stroke-width:4px
    style D6 fill:#fff9c4,stroke:#f57f17,stroke-width:4px
    style P8 fill:#e8f5e9,stroke:#1b5e20,stroke-width:2px
```

---

### P3.0 Manajemen Layanan

```mermaid
graph TB
    %% External Entities
    SuperAdmin["Super Admin"]
    Admin["Admin"]
    
    %% Sub-processes
    P31["P3.1<br/>Tambah Data<br/>Layanan"]
    P32["P3.2<br/>Ubah Data<br/>Layanan"]
    P33["P3.3<br/>Hapus Data<br/>Layanan"]
    P34["P3.4<br/>Validasi Data<br/>Layanan"]
    
    %% Data Stores
    D3["D3<br/>services"]
    D6["D6<br/>activity_logs"]
    
    %% External Process
    P8["P8.0<br/>Auto-Translation"]
    
    %% Flows from External Entities
    SuperAdmin -->|"info data layanan"| P31
    SuperAdmin -->|"info data layanan"| P32
    SuperAdmin -->|"info data layanan"| P33
    Admin -->|"info data layanan"| P31
    Admin -->|"info data layanan"| P32
    Admin -->|"info data layanan"| P33
    
    %% Flows between processes
    P31 -->|"info data layanan"| P34
    P32 -->|"info data layanan"| P34
    P33 -->|"info data layanan"| P34
    P34 -->|"data layanan update"| P31
    P34 -->|"data layanan update"| P32
    P34 -->|"data layanan update"| P33
    
    %% Flows to Data Store
    P34 -->|"info data layanan"| D3
    D3 -->|"data layanan update"| P34
    
    %% Flows to Activity Log
    P34 -->|"data log aktivitas"| D6
    
    %% Flows to Auto-Translation
    P34 -->|"data teks bahasa Indonesia"| P8
    P8 -->|"info teks terjemahan"| P34
    
    %% Flows back to External Entities
    P31 -->|"data layanan update"| SuperAdmin
    P31 -->|"data layanan update"| Admin
    P32 -->|"data layanan update"| SuperAdmin
    P32 -->|"data layanan update"| Admin
    P33 -->|"data layanan update"| SuperAdmin
    P33 -->|"data layanan update"| Admin
    P34 -->|"data layanan update"| SuperAdmin
    P34 -->|"data layanan update"| Admin
    
    style P31 fill:#e3f2fd,stroke:#1976d2,stroke-width:2px
    style P32 fill:#e3f2fd,stroke:#1976d2,stroke-width:2px
    style P33 fill:#e3f2fd,stroke:#1976d2,stroke-width:2px
    style P34 fill:#e3f2fd,stroke:#1976d2,stroke-width:2px
    style SuperAdmin fill:#ffebee,stroke:#c62828,stroke-width:2px
    style Admin fill:#fff3e0,stroke:#e65100,stroke-width:2px
    style D3 fill:#fff9c4,stroke:#f57f17,stroke-width:4px
    style D6 fill:#fff9c4,stroke:#f57f17,stroke-width:4px
    style P8 fill:#e8f5e9,stroke:#1b5e20,stroke-width:2px
```

---

### P4.0 Manajemen FAQ

```mermaid
graph TB
    %% External Entities
    SuperAdmin["Super Admin"]
    Admin["Admin"]
    
    %% Sub-processes
    P41["P4.1<br/>Tambah Data<br/>FAQ"]
    P42["P4.2<br/>Ubah Data<br/>FAQ"]
    P43["P4.3<br/>Hapus Data<br/>FAQ"]
    P44["P4.4<br/>Validasi Data<br/>FAQ"]
    
    %% Data Stores
    D4["D4<br/>faqs"]
    D6["D6<br/>activity_logs"]
    
    %% External Process
    P8["P8.0<br/>Auto-Translation"]
    
    %% Flows from External Entities
    SuperAdmin -->|"info data FAQ"| P41
    SuperAdmin -->|"info data FAQ"| P42
    SuperAdmin -->|"info data FAQ"| P43
    Admin -->|"info data FAQ"| P41
    Admin -->|"info data FAQ"| P42
    Admin -->|"info data FAQ"| P43
    
    %% Flows between processes
    P41 -->|"info data FAQ"| P44
    P42 -->|"info data FAQ"| P44
    P43 -->|"info data FAQ"| P44
    P44 -->|"data FAQ update"| P41
    P44 -->|"data FAQ update"| P42
    P44 -->|"data FAQ update"| P43
    
    %% Flows to Data Store
    P44 -->|"info data FAQ"| D4
    D4 -->|"data FAQ update"| P44
    
    %% Flows to Activity Log
    P44 -->|"data log aktivitas"| D6
    
    %% Flows to Auto-Translation
    P44 -->|"data teks bahasa Indonesia"| P8
    P8 -->|"info teks terjemahan"| P44
    
    %% Flows back to External Entities
    P41 -->|"data FAQ update"| SuperAdmin
    P41 -->|"data FAQ update"| Admin
    P42 -->|"data FAQ update"| SuperAdmin
    P42 -->|"data FAQ update"| Admin
    P43 -->|"data FAQ update"| SuperAdmin
    P43 -->|"data FAQ update"| Admin
    P44 -->|"data FAQ update"| SuperAdmin
    P44 -->|"data FAQ update"| Admin
    
    style P41 fill:#e3f2fd,stroke:#1976d2,stroke-width:2px
    style P42 fill:#e3f2fd,stroke:#1976d2,stroke-width:2px
    style P43 fill:#e3f2fd,stroke:#1976d2,stroke-width:2px
    style P44 fill:#e3f2fd,stroke:#1976d2,stroke-width:2px
    style SuperAdmin fill:#ffebee,stroke:#c62828,stroke-width:2px
    style Admin fill:#fff3e0,stroke:#e65100,stroke-width:2px
    style D4 fill:#fff9c4,stroke:#f57f17,stroke-width:4px
    style D6 fill:#fff9c4,stroke:#f57f17,stroke-width:4px
    style P8 fill:#e8f5e9,stroke:#1b5e20,stroke-width:2px
```

---

### P5.0 Manajemen Konten

```mermaid
graph TB
    %% External Entities
    SuperAdmin["Super Admin"]
    Admin["Admin"]
    
    %% Sub-processes
    P51["P5.1<br/>Tambah Data<br/>Konten"]
    P52["P5.2<br/>Ubah Data<br/>Konten"]
    P53["P5.3<br/>Hapus Data<br/>Konten"]
    P54["P5.4<br/>Validasi Data<br/>Konten"]
    
    %% Data Stores
    D5["D5<br/>content_pages"]
    D6["D6<br/>activity_logs"]
    
    %% External Process
    P8["P8.0<br/>Auto-Translation"]
    
    %% Flows from External Entities
    SuperAdmin -->|"info data konten halaman"| P51
    SuperAdmin -->|"info data konten halaman"| P52
    SuperAdmin -->|"info data konten halaman"| P53
    Admin -->|"info data konten halaman"| P51
    Admin -->|"info data konten halaman"| P52
    Admin -->|"info data konten halaman"| P53
    
    %% Flows between processes
    P51 -->|"info data konten halaman"| P54
    P52 -->|"info data konten halaman"| P54
    P53 -->|"info data konten halaman"| P54
    P54 -->|"data konten halaman update"| P51
    P54 -->|"data konten halaman update"| P52
    P54 -->|"data konten halaman update"| P53
    
    %% Flows to Data Store
    P54 -->|"info data konten halaman"| D5
    D5 -->|"data konten halaman update"| P54
    
    %% Flows to Activity Log
    P54 -->|"data log aktivitas"| D6
    
    %% Flows to Auto-Translation
    P54 -->|"data teks bahasa Indonesia"| P8
    P8 -->|"info teks terjemahan"| P54
    
    %% Flows back to External Entities
    P51 -->|"data konten halaman update"| SuperAdmin
    P51 -->|"data konten halaman update"| Admin
    P52 -->|"data konten halaman update"| SuperAdmin
    P52 -->|"data konten halaman update"| Admin
    P53 -->|"data konten halaman update"| SuperAdmin
    P53 -->|"data konten halaman update"| Admin
    P54 -->|"data konten halaman update"| SuperAdmin
    P54 -->|"data konten halaman update"| Admin
    
    style P51 fill:#e3f2fd,stroke:#1976d2,stroke-width:2px
    style P52 fill:#e3f2fd,stroke:#1976d2,stroke-width:2px
    style P53 fill:#e3f2fd,stroke:#1976d2,stroke-width:2px
    style P54 fill:#e3f2fd,stroke:#1976d2,stroke-width:2px
    style SuperAdmin fill:#ffebee,stroke:#c62828,stroke-width:2px
    style Admin fill:#fff3e0,stroke:#e65100,stroke-width:2px
    style D5 fill:#fff9c4,stroke:#f57f17,stroke-width:4px
    style D6 fill:#fff9c4,stroke:#f57f17,stroke-width:4px
    style P8 fill:#e8f5e9,stroke:#1b5e20,stroke-width:2px
```

---

### P6.0 Manajemen User

```mermaid
graph TB
    %% External Entities
    SuperAdmin["Super Admin"]
    
    %% Sub-processes
    P61["P6.1<br/>Tambah Data<br/>User Admin"]
    P62["P6.2<br/>Ubah Data<br/>User Admin"]
    P63["P6.3<br/>Hapus Data<br/>User Admin"]
    P64["P6.4<br/>Validasi Data<br/>User Admin"]
    
    %% Data Stores
    D1["D1<br/>admin_users"]
    D6["D6<br/>activity_logs"]
    
    %% Flows from External Entities
    SuperAdmin -->|"info data user admin"| P61
    SuperAdmin -->|"info data user admin"| P62
    SuperAdmin -->|"info data user admin"| P63
    
    %% Flows between processes
    P61 -->|"info data user admin"| P64
    P62 -->|"info data user admin"| P64
    P63 -->|"info data user admin"| P64
    P64 -->|"data user admin update"| P61
    P64 -->|"data user admin update"| P62
    P64 -->|"data user admin update"| P63
    
    %% Flows to Data Store
    P64 -->|"info data user admin"| D1
    D1 -->|"data user admin update"| P64
    
    %% Flows to Activity Log
    P64 -->|"data log aktivitas"| D6
    
    %% Flows back to External Entities
    P61 -->|"data user admin update"| SuperAdmin
    P62 -->|"data user admin update"| SuperAdmin
    P63 -->|"data user admin update"| SuperAdmin
    P64 -->|"data user admin update"| SuperAdmin
    
    style P61 fill:#e3f2fd,stroke:#1976d2,stroke-width:2px
    style P62 fill:#e3f2fd,stroke:#1976d2,stroke-width:2px
    style P63 fill:#e3f2fd,stroke:#1976d2,stroke-width:2px
    style P64 fill:#e3f2fd,stroke:#1976d2,stroke-width:2px
    style SuperAdmin fill:#ffebee,stroke:#c62828,stroke-width:2px
    style D1 fill:#fff9c4,stroke:#f57f17,stroke-width:4px
    style D6 fill:#fff9c4,stroke:#f57f17,stroke-width:4px
```

---

### P7.0 Pengaturan Akun

```mermaid
graph TB
    %% External Entities
    SuperAdmin["Super Admin"]
    Admin["Admin"]
    
    %% Sub-processes
    P71["P7.1<br/>Ubah Username"]
    P72["P7.2<br/>Ubah Password"]
    P73["P7.3<br/>Validasi<br/>Pengaturan Akun"]
    
    %% Data Stores
    D1["D1<br/>admin_users"]
    D6["D6<br/>activity_logs"]
    
    %% Flows from External Entities
    SuperAdmin -->|"info data pengaturan akun"| P71
    SuperAdmin -->|"info data pengaturan akun"| P72
    Admin -->|"info data pengaturan akun"| P71
    Admin -->|"info data pengaturan akun"| P72
    
    %% Flows between processes
    P71 -->|"info data pengaturan akun"| P73
    P72 -->|"info data pengaturan akun"| P73
    P73 -->|"data pengaturan akun update"| P71
    P73 -->|"data pengaturan akun update"| P72
    
    %% Flows to Data Store
    P73 -->|"info data admin user"| D1
    D1 -->|"data admin user update"| P73
    
    %% Flows to Activity Log
    P73 -->|"data log aktivitas"| D6
    
    %% Flows back to External Entities
    P71 -->|"data pengaturan akun update"| SuperAdmin
    P71 -->|"data pengaturan akun update"| Admin
    P72 -->|"data pengaturan akun update"| SuperAdmin
    P72 -->|"data pengaturan akun update"| Admin
    P73 -->|"data pengaturan akun update"| SuperAdmin
    P73 -->|"data pengaturan akun update"| Admin
    
    style P71 fill:#e3f2fd,stroke:#1976d2,stroke-width:2px
    style P72 fill:#e3f2fd,stroke:#1976d2,stroke-width:2px
    style P73 fill:#e3f2fd,stroke:#1976d2,stroke-width:2px
    style SuperAdmin fill:#ffebee,stroke:#c62828,stroke-width:2px
    style Admin fill:#fff3e0,stroke:#e65100,stroke-width:2px
    style D1 fill:#fff9c4,stroke:#f57f17,stroke-width:4px
    style D6 fill:#fff9c4,stroke:#f57f17,stroke-width:4px
```

---

### P8.0 Auto-Translation

```mermaid
graph TB
    %% External Entities
    GoogleAPI["Google Translate API"]
    
    %% Sub-processes
    P81["P8.1<br/>Terima Teks<br/>Bahasa Indonesia"]
    P82["P8.2<br/>Panggil API<br/>Translation"]
    P83["P8.3<br/>Proses Hasil<br/>Terjemahan"]
    
    %% Flows
    P81 -->|"data teks bahasa Indonesia"| P82
    P82 -->|"data teks bahasa Indonesia"| GoogleAPI
    GoogleAPI -->|"info teks terjemahan"| P82
    P82 -->|"info teks terjemahan"| P83
    P83 -->|"info teks terjemahan"| P81
    
    style P81 fill:#e3f2fd,stroke:#1976d2,stroke-width:2px
    style P82 fill:#e3f2fd,stroke:#1976d2,stroke-width:2px
    style P83 fill:#e3f2fd,stroke:#1976d2,stroke-width:2px
    style GoogleAPI fill:#e8f5e9,stroke:#1b5e20,stroke-width:2px
```

---

### P9.0 Tampilkan Website

```mermaid
graph TB
    %% External Entities
    Visitor["Pengunjung Website"]
    
    %% Sub-processes
    P91["P9.1<br/>Terima Request<br/>Halaman"]
    P92["P9.2<br/>Baca Data dari<br/>Database"]
    P93["P9.3<br/>Lokalisasi Konten<br/>Berdasarkan Bahasa"]
    P94["P9.4<br/>Render Halaman<br/>Website"]
    
    %% Data Stores
    D2["D2<br/>doctors"]
    D3["D3<br/>services"]
    D4["D4<br/>faqs"]
    D5["D5<br/>content_pages"]
    D7["D7<br/>sessions"]
    
    %% Flows from External Entities
    Visitor -->|"data request halaman"| P91
    Visitor -->|"data pilihan bahasa"| P91
    Visitor -->|"data response kuesioner"| P91
    
    %% Flows between processes
    P91 -->|"data request"| P92
    P92 -->|"data konten"| P93
    P93 -->|"data konten terlokalisasi"| P94
    P94 -->|"info konten website"| Visitor
    P94 -->|"info dokter"| Visitor
    P94 -->|"info layanan"| Visitor
    P94 -->|"info FAQ"| Visitor
    P94 -->|"info konten halaman"| Visitor
    P94 -->|"info layout prioritas"| Visitor
    
    %% Flows to Data Stores
    P92 -->|"data request"| D2
    P92 -->|"data request"| D3
    P92 -->|"data request"| D4
    P92 -->|"data request"| D5
    P91 <-->|"data session"| D7
    P93 <-->|"data session"| D7
    
    style P91 fill:#e3f2fd,stroke:#1976d2,stroke-width:2px
    style P92 fill:#e3f2fd,stroke:#1976d2,stroke-width:2px
    style P93 fill:#e3f2fd,stroke:#1976d2,stroke-width:2px
    style P94 fill:#e3f2fd,stroke:#1976d2,stroke-width:2px
    style Visitor fill:#f3e5f5,stroke:#4a148c,stroke-width:2px
    style D2 fill:#fff9c4,stroke:#f57f17,stroke-width:4px
    style D3 fill:#fff9c4,stroke:#f57f17,stroke-width:4px
    style D4 fill:#fff9c4,stroke:#f57f17,stroke-width:4px
    style D5 fill:#fff9c4,stroke:#f57f17,stroke-width:4px
    style D7 fill:#fff9c4,stroke:#f57f17,stroke-width:4px
```

---

## Deskripsi Sub-Proses

### P1.0 Login

#### P1.1 Masukkan Username & Password
**Deskripsi:** Proses untuk menerima input username dan password dari Super Admin atau Admin.

**Input:**
- `login` dari Super Admin/Admin

**Output:**
- `data username & password` ke P1.2

---

#### P1.2 Verifikasi User
**Deskripsi:** Proses untuk memverifikasi kredensial user dengan data di database.

**Input:**
- `data username & password` dari P1.1
- `data login` dari D1 (admin_users)

**Output:**
- `pesan login berhasil atau gagal` ke Super Admin/Admin
- `data session` ke D7 (sessions)
- `data log aktivitas` ke D6 (activity_logs)

**Data Store:**
- D1 (admin_users) - membaca data login
- D7 (sessions) - menulis data session
- D6 (activity_logs) - menulis log aktivitas

---

### P2.0 Manajemen Dokter

#### P2.1 Tambah Data Dokter
**Deskripsi:** Proses untuk menambahkan data dokter baru.

**Input:**
- `info data dokter` dari Super Admin/Admin
- `data dokter update` dari P2.4

**Output:**
- `data dokter update` ke Super Admin/Admin
- `info data dokter` ke P2.4

---

#### P2.2 Ubah Data Dokter
**Deskripsi:** Proses untuk mengubah data dokter yang sudah ada.

**Input:**
- `info data dokter` dari Super Admin/Admin
- `data dokter update` dari P2.4

**Output:**
- `data dokter update` ke Super Admin/Admin
- `info data dokter` ke P2.4

---

#### P2.3 Hapus Data Dokter
**Deskripsi:** Proses untuk menghapus data dokter.

**Input:**
- `info data dokter` dari Super Admin/Admin
- `data dokter update` dari P2.4

**Output:**
- `data dokter update` ke Super Admin/Admin
- `info data dokter` ke P2.4

---

#### P2.4 Validasi Data Dokter
**Deskripsi:** Proses untuk memvalidasi data dokter sebelum disimpan ke database, termasuk auto-translation.

**Input:**
- `info data dokter` dari P2.1, P2.2, P2.3
- `data dokter update` dari D2 (doctors)
- `info teks terjemahan` dari P8.0

**Output:**
- `data dokter update` ke P2.1, P2.2, P2.3, Super Admin/Admin
- `info data dokter` ke D2 (doctors)
- `data log aktivitas` ke D6 (activity_logs)
- `data teks bahasa Indonesia` ke P8.0

**Data Store:**
- D2 (doctors) - membaca dan menulis data dokter
- D6 (activity_logs) - menulis log aktivitas

---

### P3.0 Manajemen Layanan

#### P3.1 Tambah Data Layanan
**Deskripsi:** Proses untuk menambahkan data layanan baru.

**Input:**
- `info data layanan` dari Super Admin/Admin
- `data layanan update` dari P3.4

**Output:**
- `data layanan update` ke Super Admin/Admin
- `info data layanan` ke P3.4

---

#### P3.2 Ubah Data Layanan
**Deskripsi:** Proses untuk mengubah data layanan yang sudah ada.

**Input:**
- `info data layanan` dari Super Admin/Admin
- `data layanan update` dari P3.4

**Output:**
- `data layanan update` ke Super Admin/Admin
- `info data layanan` ke P3.4

---

#### P3.3 Hapus Data Layanan
**Deskripsi:** Proses untuk menghapus data layanan.

**Input:**
- `info data layanan` dari Super Admin/Admin
- `data layanan update` dari P3.4

**Output:**
- `data layanan update` ke Super Admin/Admin
- `info data layanan` ke P3.4

---

#### P3.4 Validasi Data Layanan
**Deskripsi:** Proses untuk memvalidasi data layanan sebelum disimpan ke database, termasuk auto-translation.

**Input:**
- `info data layanan` dari P3.1, P3.2, P3.3
- `data layanan update` dari D3 (services)
- `info teks terjemahan` dari P8.0

**Output:**
- `data layanan update` ke P3.1, P3.2, P3.3, Super Admin/Admin
- `info data layanan` ke D3 (services)
- `data log aktivitas` ke D6 (activity_logs)
- `data teks bahasa Indonesia` ke P8.0

**Data Store:**
- D3 (services) - membaca dan menulis data layanan
- D6 (activity_logs) - menulis log aktivitas

---

### P4.0 Manajemen FAQ

#### P4.1 Tambah Data FAQ
**Deskripsi:** Proses untuk menambahkan data FAQ baru.

**Input:**
- `info data FAQ` dari Super Admin/Admin
- `data FAQ update` dari P4.4

**Output:**
- `data FAQ update` ke Super Admin/Admin
- `info data FAQ` ke P4.4

---

#### P4.2 Ubah Data FAQ
**Deskripsi:** Proses untuk mengubah data FAQ yang sudah ada.

**Input:**
- `info data FAQ` dari Super Admin/Admin
- `data FAQ update` dari P4.4

**Output:**
- `data FAQ update` ke Super Admin/Admin
- `info data FAQ` ke P4.4

---

#### P4.3 Hapus Data FAQ
**Deskripsi:** Proses untuk menghapus data FAQ.

**Input:**
- `info data FAQ` dari Super Admin/Admin
- `data FAQ update` dari P4.4

**Output:**
- `data FAQ update` ke Super Admin/Admin
- `info data FAQ` ke P4.4

---

#### P4.4 Validasi Data FAQ
**Deskripsi:** Proses untuk memvalidasi data FAQ sebelum disimpan ke database, termasuk auto-translation.

**Input:**
- `info data FAQ` dari P4.1, P4.2, P4.3
- `data FAQ update` dari D4 (faqs)
- `info teks terjemahan` dari P8.0

**Output:**
- `data FAQ update` ke P4.1, P4.2, P4.3, Super Admin/Admin
- `info data FAQ` ke D4 (faqs)
- `data log aktivitas` ke D6 (activity_logs)
- `data teks bahasa Indonesia` ke P8.0

**Data Store:**
- D4 (faqs) - membaca dan menulis data FAQ
- D6 (activity_logs) - menulis log aktivitas

---

### P5.0 Manajemen Konten

#### P5.1 Tambah Data Konten
**Deskripsi:** Proses untuk menambahkan konten halaman baru.

**Input:**
- `info data konten halaman` dari Super Admin/Admin
- `data konten halaman update` dari P5.4

**Output:**
- `data konten halaman update` ke Super Admin/Admin
- `info data konten halaman` ke P5.4

---

#### P5.2 Ubah Data Konten
**Deskripsi:** Proses untuk mengubah konten halaman yang sudah ada.

**Input:**
- `info data konten halaman` dari Super Admin/Admin
- `data konten halaman update` dari P5.4

**Output:**
- `data konten halaman update` ke Super Admin/Admin
- `info data konten halaman` ke P5.4

---

#### P5.3 Hapus Data Konten
**Deskripsi:** Proses untuk menghapus konten halaman.

**Input:**
- `info data konten halaman` dari Super Admin/Admin
- `data konten halaman update` dari P5.4

**Output:**
- `data konten halaman update` ke Super Admin/Admin
- `info data konten halaman` ke P5.4

---

#### P5.4 Validasi Data Konten
**Deskripsi:** Proses untuk memvalidasi konten halaman sebelum disimpan ke database, termasuk auto-translation.

**Input:**
- `info data konten halaman` dari P5.1, P5.2, P5.3
- `data konten halaman update` dari D5 (content_pages)
- `info teks terjemahan` dari P8.0

**Output:**
- `data konten halaman update` ke P5.1, P5.2, P5.3, Super Admin/Admin
- `info data konten halaman` ke D5 (content_pages)
- `data log aktivitas` ke D6 (activity_logs)
- `data teks bahasa Indonesia` ke P8.0

**Data Store:**
- D5 (content_pages) - membaca dan menulis data konten
- D6 (activity_logs) - menulis log aktivitas

---

### P6.0 Manajemen User

#### P6.1 Tambah Data User Admin
**Deskripsi:** Proses untuk menambahkan user admin baru (hanya Super Admin).

**Input:**
- `info data user admin` dari Super Admin
- `data user admin update` dari P6.4

**Output:**
- `data user admin update` ke Super Admin
- `info data user admin` ke P6.4

---

#### P6.2 Ubah Data User Admin
**Deskripsi:** Proses untuk mengubah data user admin yang sudah ada (hanya Super Admin).

**Input:**
- `info data user admin` dari Super Admin
- `data user admin update` dari P6.4

**Output:**
- `data user admin update` ke Super Admin
- `info data user admin` ke P6.4

---

#### P6.3 Hapus Data User Admin
**Deskripsi:** Proses untuk menghapus user admin (hanya Super Admin).

**Input:**
- `info data user admin` dari Super Admin
- `data user admin update` dari P6.4

**Output:**
- `data user admin update` ke Super Admin
- `info data user admin` ke P6.4

---

#### P6.4 Validasi Data User Admin
**Deskripsi:** Proses untuk memvalidasi data user admin sebelum disimpan ke database.

**Input:**
- `info data user admin` dari P6.1, P6.2, P6.3
- `data user admin update` dari D1 (admin_users)

**Output:**
- `data user admin update` ke P6.1, P6.2, P6.3, Super Admin
- `info data user admin` ke D1 (admin_users)
- `data log aktivitas` ke D6 (activity_logs)

**Data Store:**
- D1 (admin_users) - membaca dan menulis data user admin
- D6 (activity_logs) - menulis log aktivitas

---

### P7.0 Pengaturan Akun

#### P7.1 Ubah Username
**Deskripsi:** Proses untuk mengubah username akun yang sedang login.

**Input:**
- `info data pengaturan akun` dari Super Admin/Admin
- `data pengaturan akun update` dari P7.3

**Output:**
- `data pengaturan akun update` ke Super Admin/Admin
- `info data pengaturan akun` ke P7.3

---

#### P7.2 Ubah Password
**Deskripsi:** Proses untuk mengubah password akun yang sedang login.

**Input:**
- `info data pengaturan akun` dari Super Admin/Admin
- `data pengaturan akun update` dari P7.3

**Output:**
- `data pengaturan akun update` ke Super Admin/Admin
- `info data pengaturan akun` ke P7.3

---

#### P7.3 Validasi Pengaturan Akun
**Deskripsi:** Proses untuk memvalidasi perubahan username atau password sebelum disimpan ke database.

**Input:**
- `info data pengaturan akun` dari P7.1, P7.2
- `data admin user update` dari D1 (admin_users)

**Output:**
- `data pengaturan akun update` ke P7.1, P7.2, Super Admin/Admin
- `info data admin user` ke D1 (admin_users)
- `data log aktivitas` ke D6 (activity_logs)

**Data Store:**
- D1 (admin_users) - membaca dan menulis data admin user
- D6 (activity_logs) - menulis log aktivitas

---

### P8.0 Auto-Translation

#### P8.1 Terima Teks Bahasa Indonesia
**Deskripsi:** Proses untuk menerima teks bahasa Indonesia dari proses manajemen konten.

**Input:**
- `data teks bahasa Indonesia` dari P2.4, P3.4, P4.4, P5.4
- `info teks terjemahan` dari P8.3

**Output:**
- `info teks terjemahan` ke P2.4, P3.4, P4.4, P5.4
- `data teks bahasa Indonesia` ke P8.2

---

#### P8.2 Panggil API Translation
**Deskripsi:** Proses untuk memanggil Google Translate API untuk menerjemahkan teks.

**Input:**
- `data teks bahasa Indonesia` dari P8.1
- `info teks terjemahan` dari Google Translate API

**Output:**
- `data teks bahasa Indonesia` ke Google Translate API
- `info teks terjemahan` ke P8.3

**External Entity:**
- Google Translate API

---

#### P8.3 Proses Hasil Terjemahan
**Deskripsi:** Proses untuk memproses hasil terjemahan dari API dan mengembalikannya ke proses pemanggil.

**Input:**
- `info teks terjemahan` dari P8.2

**Output:**
- `info teks terjemahan` ke P8.1

---

### P9.0 Tampilkan Website

#### P9.1 Terima Request Halaman
**Deskripsi:** Proses untuk menerima request halaman dari pengunjung website.

**Input:**
- `data request halaman` dari Pengunjung Website
- `data pilihan bahasa` dari Pengunjung Website
- `data response kuesioner` dari Pengunjung Website

**Output:**
- `data request` ke P9.2
- `data session` ke/dari D7 (sessions)

**Data Store:**
- D7 (sessions) - membaca dan menulis data session

---

#### P9.2 Baca Data dari Database
**Deskripsi:** Proses untuk membaca data dari berbagai data store sesuai request.

**Input:**
- `data request` dari P9.1
- `data` dari D2, D3, D4, D5

**Output:**
- `data konten` ke P9.3
- `data request` ke D2, D3, D4, D5

**Data Store:**
- D2 (doctors) - membaca data dokter
- D3 (services) - membaca data layanan
- D4 (faqs) - membaca data FAQ
- D5 (content_pages) - membaca data konten

---

#### P9.3 Lokalisasi Konten Berdasarkan Bahasa
**Deskripsi:** Proses untuk melokalisasi konten berdasarkan bahasa yang dipilih pengunjung.

**Input:**
- `data konten` dari P9.2
- `data session` dari D7 (sessions)

**Output:**
- `data konten terlokalisasi` ke P9.4
- `data session` ke/dari D7 (sessions)

**Data Store:**
- D7 (sessions) - membaca dan menulis data session

---

#### P9.4 Render Halaman Website
**Deskripsi:** Proses untuk merender halaman website dengan konten yang sudah terlokalisasi.

**Input:**
- `data konten terlokalisasi` dari P9.3

**Output:**
- `info konten website` ke Pengunjung Website
- `info dokter` ke Pengunjung Website
- `info layanan` ke Pengunjung Website
- `info FAQ` ke Pengunjung Website
- `info konten halaman` ke Pengunjung Website
- `info layout prioritas` ke Pengunjung Website

---

## Hubungan dengan DFD Level 0

**DFD Level 0** menampilkan 9 proses utama:
- P1.0 Login
- P2.0 Manajemen Dokter
- P3.0 Manajemen Layanan
- P4.0 Manajemen FAQ
- P5.0 Manajemen Konten
- P6.0 Manajemen User
- P7.0 Pengaturan Akun
- P8.0 Auto-Translation
- P9.0 Tampilkan Website

**DFD Level 1** memecah setiap proses utama menjadi sub-proses detail:
- **P1.0 Login** → P1.1 Masukkan Username & Password, P1.2 Verifikasi User
- **P2.0 Manajemen Dokter** → P2.1 Tambah, P2.2 Ubah, P2.3 Hapus, P2.4 Validasi
- **P3.0 Manajemen Layanan** → P3.1 Tambah, P3.2 Ubah, P3.3 Hapus, P3.4 Validasi
- **P4.0 Manajemen FAQ** → P4.1 Tambah, P4.2 Ubah, P4.3 Hapus, P4.4 Validasi
- **P5.0 Manajemen Konten** → P5.1 Tambah, P5.2 Ubah, P5.3 Hapus, P5.4 Validasi
- **P6.0 Manajemen User** → P6.1 Tambah, P6.2 Ubah, P6.3 Hapus, P6.4 Validasi
- **P7.0 Pengaturan Akun** → P7.1 Ubah Username, P7.2 Ubah Password, P7.3 Validasi
- **P8.0 Auto-Translation** → P8.1 Terima Teks, P8.2 Panggil API, P8.3 Proses Hasil
- **P9.0 Tampilkan Website** → P9.1 Terima Request, P9.2 Baca Data, P9.3 Lokalisasi, P9.4 Render

---

## Catatan Penting

1. **P6.0 Manajemen User** hanya dapat diakses oleh Super Admin
2. **P8.0 Auto-Translation** bekerja secara otomatis saat proses validasi (P2.4, P3.4, P4.4, P5.4) memproses data dalam bahasa Indonesia
3. **P9.0 Tampilkan Website** membaca data dari multiple data stores dan melokalisasi konten berdasarkan bahasa yang dipilih pengunjung
4. Semua proses validasi (P2.4, P3.4, P4.4, P5.4, P6.4, P7.3) mencatat aktivitas ke D6 (activity_logs)
5. Proses validasi untuk konten (P2.4, P3.4, P4.4, P5.4) mengirim data ke P8.0 untuk auto-translation sebelum menyimpan ke database

---

**Versi:** 2.0  
**Tanggal:** 2025-01-14  
**Status:** Current
