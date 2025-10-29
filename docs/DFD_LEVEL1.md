# DFD Level 1 - Legian Medical Clinic Website

## Overview
DFD Level 1 memecah sistem menjadi proses-proses detail yang menunjukkan alur data internal sistem.

---

## 1. DFD Level 1 - Login/Register Admin (P1.0)

```mermaid
graph TB
    Admin["Admin User"]
    
    P11["1.1 Masukkan<br/>Username & Password"]
    P12["1.2 Verifikasi<br/>Admin User"]
    
    DB1[("tb_admin_users")]
    
    %% Admin to Process
    Admin -->|"login"| P11
    
    %% Process to Process
    P11 --> P12
    
    %% Process to Database
    P12 -->|"query data admin"| DB1
    DB1 -->|"data admin user"| P12
    
    %% Process to Admin
    P12 -->|"pesan login berhasil atau gagal"| Admin
    
    style P11 fill:#E8F4F8,stroke:#2E5C8A,stroke-width:2px,color:#000
    style P12 fill:#E8F4F8,stroke:#2E5C8A,stroke-width:2px,color:#000
    style Admin fill:#fff,stroke:#C92A2A,stroke-width:2px,color:#000
    style DB1 fill:#fff,stroke:#6B3483,stroke-width:2px,color:#000
```

**Keterangan:**
- **1.1 Masukkan Username & Password**: Proses menerima input username dan password dari admin
- **1.2 Verifikasi Admin User**: Proses memverifikasi kredensial dengan database dan mengembalikan pesan sukses/gagal

---

## 2. DFD Level 1 - Manajemen Dokter (P2.0)

```mermaid
graph TB
    Admin["Admin User"]
    
    P21["2.1 Tambah Data<br/>Dokter"]
    P22["2.2 Ubah Data<br/>Dokter"]
    P23["2.3 Hapus Data<br/>Dokter"]
    P24["2.4 Validasi Data<br/>Dokter"]
    
    DB2[("tb_doctors")]
    Storage2[("File Storage")]
    
    %% Admin to Process
    Admin -->|"info data dokter"| P21
    Admin -->|"info data dokter"| P22
    Admin -->|"info data dokter"| P23
    
    %% Process to Process
    P21 -->|"info data dokter"| P24
    P22 -->|"info data dokter"| P24
    P23 -->|"info data dokter"| P24
    
    %% Process to Admin
    P21 -->|"data dokter update"| Admin
    P22 -->|"data dokter update"| Admin
    P23 -->|"data dokter update"| Admin
    
    %% Process to Database
    P24 -->|"info data dokter"| DB2
    DB2 -->|"data dokter update"| P24
    
    %% Process to Storage (for photo)
    P24 -->|"file foto dokter"| Storage2
    Storage2 -->|"info file"| P24
    
    %% Process to Process (validation feedback)
    P24 -->|"data dokter update"| P21
    P24 -->|"data dokter update"| P22
    P24 -->|"data dokter update"| P23
    
    style P21 fill:#E8F4F8,stroke:#2E5C8A,stroke-width:2px,color:#000
    style P22 fill:#E8F4F8,stroke:#2E5C8A,stroke-width:2px,color:#000
    style P23 fill:#E8F4F8,stroke:#2E5C8A,stroke-width:2px,color:#000
    style P24 fill:#E8F4F8,stroke:#2E5C8A,stroke-width:2px,color:#000
    style Admin fill:#fff,stroke:#C92A2A,stroke-width:2px,color:#000
    style DB2 fill:#fff,stroke:#6B3483,stroke-width:2px,color:#000
    style Storage2 fill:#fff,stroke:#117A65,stroke-width:2px,color:#000
```

**Keterangan:**
- **2.1 Tambah Data Dokter**: Proses menambah data dokter baru
- **2.2 Ubah Data Dokter**: Proses mengubah data dokter yang sudah ada
- **2.3 Hapus Data Dokter**: Proses menghapus data dokter
- **2.4 Validasi Data Dokter**: Proses memvalidasi data sebelum disimpan ke database dan storage

---

## 3. DFD Level 1 - Manajemen Layanan (P3.0)

```mermaid
graph TB
    Admin["Admin User"]
    
    P31["3.1 Tambah Data<br/>Layanan"]
    P32["3.2 Ubah Data<br/>Layanan"]
    P33["3.3 Hapus Data<br/>Layanan"]
    P34["3.4 Validasi Data<br/>Layanan"]
    
    DB3[("tb_services")]
    Storage3[("File Storage")]
    
    %% Admin to Process
    Admin -->|"info data layanan"| P31
    Admin -->|"info data layanan"| P32
    Admin -->|"info data layanan"| P33
    
    %% Process to Process
    P31 -->|"info data layanan"| P34
    P32 -->|"info data layanan"| P34
    P33 -->|"info data layanan"| P34
    
    %% Process to Admin
    P31 -->|"data layanan update"| Admin
    P32 -->|"data layanan update"| Admin
    P33 -->|"data layanan update"| Admin
    
    %% Process to Database
    P34 -->|"info data layanan"| DB3
    DB3 -->|"data layanan update"| P34
    
    %% Process to Storage (for icon)
    P34 -->|"file icon layanan"| Storage3
    Storage3 -->|"info file"| P34
    
    %% Process to Process (validation feedback)
    P34 -->|"data layanan update"| P31
    P34 -->|"data layanan update"| P32
    P34 -->|"data layanan update"| P33
    
    style P31 fill:#E8F4F8,stroke:#2E5C8A,stroke-width:2px,color:#000
    style P32 fill:#E8F4F8,stroke:#2E5C8A,stroke-width:2px,color:#000
    style P33 fill:#E8F4F8,stroke:#2E5C8A,stroke-width:2px,color:#000
    style P34 fill:#E8F4F8,stroke:#2E5C8A,stroke-width:2px,color:#000
    style Admin fill:#fff,stroke:#C92A2A,stroke-width:2px,color:#000
    style DB3 fill:#fff,stroke:#6B3483,stroke-width:2px,color:#000
    style Storage3 fill:#fff,stroke:#117A65,stroke-width:2px,color:#000
```

**Keterangan:**
- **3.1 Tambah Data Layanan**: Proses menambah data layanan medis baru
- **3.2 Ubah Data Layanan**: Proses mengubah data layanan yang sudah ada
- **3.3 Hapus Data Layanan**: Proses menghapus data layanan
- **3.4 Validasi Data Layanan**: Proses memvalidasi data sebelum disimpan ke database dan storage

---

## 4. DFD Level 1 - Manajemen Konten Halaman (P4.0)

```mermaid
graph TB
    Admin["Admin User"]
    
    P41["4.1 Tambah/Ubah Data<br/>Konten Halaman"]
    P42["4.2 Validasi Data<br/>Konten Halaman"]
    
    DB4[("tb_content_pages")]
    
    %% Admin to Process
    Admin -->|"info data konten halaman"| P41
    
    %% Process to Process
    P41 -->|"info data konten halaman"| P42
    
    %% Process to Admin
    P41 -->|"data konten halaman update"| Admin
    
    %% Process to Database
    P42 -->|"info data konten halaman"| DB4
    DB4 -->|"data konten halaman update"| P42
    
    %% Process to Process (validation feedback)
    P42 -->|"data konten halaman update"| P41
    
    style P41 fill:#E8F4F8,stroke:#2E5C8A,stroke-width:2px,color:#000
    style P42 fill:#E8F4F8,stroke:#2E5C8A,stroke-width:2px,color:#000
    style Admin fill:#fff,stroke:#C92A2A,stroke-width:2px,color:#000
    style DB4 fill:#fff,stroke:#6B3483,stroke-width:2px,color:#000
```

**Keterangan:**
- **4.1 Tambah/Ubah Data Konten Halaman**: Proses menambah atau mengubah konten halaman (About Us, Contact, FAQ)
- **4.2 Validasi Data Konten Halaman**: Proses memvalidasi data konten sebelum disimpan ke database

---

## 5. DFD Level 1 - Manajemen FAQ (P5.0)

```mermaid
graph TB
    Admin["Admin User"]
    
    P51["5.1 Tambah Data<br/>FAQ"]
    P52["5.2 Ubah Data<br/>FAQ"]
    P53["5.3 Hapus Data<br/>FAQ"]
    P54["5.4 Validasi Data<br/>FAQ"]
    
    DB5[("tb_faqs")]
    
    %% Admin to Process
    Admin -->|"info data FAQ"| P51
    Admin -->|"info data FAQ"| P52
    Admin -->|"info data FAQ"| P53
    
    %% Process to Process
    P51 -->|"info data FAQ"| P54
    P52 -->|"info data FAQ"| P54
    P53 -->|"info data FAQ"| P54
    
    %% Process to Admin
    P51 -->|"data FAQ update"| Admin
    P52 -->|"data FAQ update"| Admin
    P53 -->|"data FAQ update"| Admin
    
    %% Process to Database
    P54 -->|"info data FAQ"| DB5
    DB5 -->|"data FAQ update"| P54
    
    %% Process to Process (validation feedback)
    P54 -->|"data FAQ update"| P51
    P54 -->|"data FAQ update"| P52
    P54 -->|"data FAQ update"| P53
    
    style P51 fill:#E8F4F8,stroke:#2E5C8A,stroke-width:2px,color:#000
    style P52 fill:#E8F4F8,stroke:#2E5C8A,stroke-width:2px,color:#000
    style P53 fill:#E8F4F8,stroke:#2E5C8A,stroke-width:2px,color:#000
    style P54 fill:#E8F4F8,stroke:#2E5C8A,stroke-width:2px,color:#000
    style Admin fill:#fff,stroke:#C92A2A,stroke-width:2px,color:#000
    style DB5 fill:#fff,stroke:#6B3483,stroke-width:2px,color:#000
```

**Keterangan:**
- **5.1 Tambah Data FAQ**: Proses menambah FAQ baru
- **5.2 Ubah Data FAQ**: Proses mengubah FAQ yang sudah ada
- **5.3 Hapus Data FAQ**: Proses menghapus FAQ (soft delete)
- **5.4 Validasi Data FAQ**: Proses memvalidasi data FAQ sebelum disimpan ke database

---

## 6. DFD Level 1 - Manajemen Tampilan Website (P6.0)

```mermaid
graph TB
    Visitor["Pengunjung Website"]
    
    P61["6.1 Ambil Data<br/>Konten"]
    P62["6.2 Format Data<br/>Tampilan"]
    P63["6.3 Proses Bahasa"]
    
    DB6[("tb_doctors")]
    DB7[("tb_services")]
    DB8[("tb_faqs")]
    DB9[("tb_content_pages")]
    Storage6[("File Storage")]
    
    %% Visitor to Process
    Visitor -->|"data bahasa"| P63
    Visitor -->|"data kuesioner"| P61
    
    %% Process to Process
    P63 -->|"info bahasa"| P61
    P61 -->|"data konten"| P62
    
    %% Process to Database
    P61 -->|"query data"| DB6
    DB6 -->|"data dokter"| P61
    
    P61 -->|"query data"| DB7
    DB7 -->|"data layanan"| P61
    
    P61 -->|"query data"| DB8
    DB8 -->|"data FAQ"| P61
    
    P61 -->|"query data"| DB9
    DB9 -->|"data konten halaman"| P61
    
    %% Process to Storage
    P61 -->|"query file"| Storage6
    Storage6 -->|"file gambar"| P61
    
    %% Process to Visitor
    P62 -->|"info dokter"| Visitor
    P62 -->|"info layanan"| Visitor
    P62 -->|"info FAQ"| Visitor
    P62 -->|"info konten halaman"| Visitor
    
    style P61 fill:#E8F4F8,stroke:#2E5C8A,stroke-width:2px,color:#000
    style P62 fill:#E8F4F8,stroke:#2E5C8A,stroke-width:2px,color:#000
    style P63 fill:#E8F4F8,stroke:#2E5C8A,stroke-width:2px,color:#000
    style Visitor fill:#fff,stroke:#2E7D4E,stroke-width:2px,color:#000
    style DB6 fill:#fff,stroke:#6B3483,stroke-width:2px,color:#000
    style DB7 fill:#fff,stroke:#6B3483,stroke-width:2px,color:#000
    style DB8 fill:#fff,stroke:#6B3483,stroke-width:2px,color:#000
    style DB9 fill:#fff,stroke:#6B3483,stroke-width:2px,color:#000
    style Storage6 fill:#fff,stroke:#117A65,stroke-width:2px,color:#000
```

**Keterangan:**
- **6.1 Ambil Data Konten**: Proses mengambil data dari database dan storage
- **6.2 Format Data Tampilan**: Proses memformat data untuk ditampilkan ke pengunjung
- **6.3 Proses Bahasa**: Proses menangani switching bahasa (ID/EN)

---

## Deskripsi Proses

### Manajemen Dokter (P2.0)
Sistem memungkinkan admin untuk menambah, mengubah, dan menghapus data dokter. Semua operasi melalui proses validasi sebelum disimpan ke database. Foto dokter disimpan di file storage.

### Manajemen Layanan (P3.0)
Sistem memungkinkan admin untuk menambah, mengubah, dan menghapus data layanan medis. Icon layanan disimpan di file storage.

### Manajemen Konten Halaman (P4.0)
Sistem memungkinkan admin untuk mengelola konten halaman About Us, Contact, dan FAQ. Konten mendukung multi-language (ID/EN).

### Manajemen FAQ (P5.0)
Sistem memungkinkan admin untuk menambah, mengubah, dan menghapus FAQ. Sistem menggunakan soft delete untuk menjaga data history.

### Manajemen Tampilan Website (P6.0)
Sistem menampilkan konten kepada pengunjung website dengan dukungan multi-language dan dynamic content prioritization berdasarkan kuesioner.

---

**Dibuat**: 2024  
**Versi**: 1.0  
**Sistem**: Legian Medical Clinic Website CMS


