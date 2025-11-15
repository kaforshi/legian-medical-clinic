# Diagram Konteks Sistem - Legian Medical Clinic (Mermaid)

## Deskripsi
Diagram konteks (Context Diagram / DFD Level 0) menggambarkan sistem secara keseluruhan dan interaksinya dengan entitas eksternal.

**Format:** Diagram ini menggunakan Mermaid yang dapat dirender di berbagai platform:
- GitHub/GitLab (otomatis di Markdown)
- VS Code dengan extension "Markdown Preview Mermaid Support"
- Online: https://mermaid.live/ atau https://mermaid-js.github.io/mermaid-live-editor/

## Diagram Konteks

```mermaid
graph TB
    %% Sistem Utama
    System(("Sistem Website<br/>Legian Medical Clinic"))
    
    %% Entitas Eksternal
    SuperAdmin["Super Admin"]
    Admin["Admin"]
    Visitor["Pengunjung Website"]
    GoogleAPI["Google Translate API"]
    
    %% Super Admin Input Flows
    SuperAdmin -->|"data login super admin"| System
    SuperAdmin -->|"data dokter"| System
    SuperAdmin -->|"data layanan"| System
    SuperAdmin -->|"data FAQ"| System
    SuperAdmin -->|"data konten halaman"| System
    SuperAdmin -->|"data hero slide"| System
    SuperAdmin -->|"data user admin"| System
    SuperAdmin -->|"data pengaturan akun"| System
    
    %% Super Admin Output Flows
    System -->|"info login"| SuperAdmin
    System -->|"info dokter"| SuperAdmin
    System -->|"info layanan"| SuperAdmin
    System -->|"info FAQ"| SuperAdmin
    System -->|"info konten halaman"| SuperAdmin
    System -->|"info hero slide"| SuperAdmin
    System -->|"info user admin"| SuperAdmin
    System -->|"info dashboard"| SuperAdmin
    System -->|"info log aktivitas"| SuperAdmin
    
    %% Admin Input Flows
    Admin -->|"data login admin"| System
    Admin -->|"data dokter"| System
    Admin -->|"data layanan"| System
    Admin -->|"data FAQ"| System
    Admin -->|"data konten halaman"| System
    Admin -->|"data hero slide"| System
    Admin -->|"data pengaturan akun"| System
    
    %% Admin Output Flows
    System -->|"info login"| Admin
    System -->|"info dokter"| Admin
    System -->|"info layanan"| Admin
    System -->|"info FAQ"| Admin
    System -->|"info konten halaman"| Admin
    System -->|"info hero slide"| Admin
    System -->|"info dashboard"| Admin
    System -->|"info log aktivitas"| Admin
    
    %% Visitor Input Flows
    Visitor -->|"data request halaman"| System
    Visitor -->|"data pilihan bahasa"| System
    Visitor -->|"data response kuesioner"| System
    
    %% Visitor Output Flows
    System -->|"info konten website"| Visitor
    System -->|"info dokter"| Visitor
    System -->|"info layanan"| Visitor
    System -->|"info FAQ"| Visitor
    System -->|"info konten halaman"| Visitor
    System -->|"info hero slide"| Visitor
    System -->|"info layout prioritas"| Visitor
    
    %% Google API Flows
    System -->|"data teks bahasa Indonesia"| GoogleAPI
    GoogleAPI -->|"info teks terjemahan"| System
    
    %% Styling
    style System fill:#e1f5ff,stroke:#01579b,stroke-width:4px
    style SuperAdmin fill:#ffebee,stroke:#c62828,stroke-width:2px
    style Admin fill:#fff3e0,stroke:#e65100,stroke-width:2px
    style Visitor fill:#f3e5f5,stroke:#4a148c,stroke-width:2px
    style GoogleAPI fill:#e8f5e9,stroke:#1b5e20,stroke-width:2px
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
**Format:** Mermaid  
**Status:** Current
