# DFD Level 1 - Legian Medical Clinic Website

## Overview
DFD Level 1 memecah setiap proses di DFD Level 0 menjadi sub-proses detail yang menunjukkan alur data internal sistem. Setiap proses utama dipecah menjadi proses-proses yang lebih spesifik sesuai dengan implementasi aktual sistem.

## Aturan DFD yang Diterapkan

1. **Penamaan Data Store**: Menggunakan format `dt_` sesuai dengan DFD Level 0 yang diberikan
2. **Alur Data**: Setiap alur data harus memiliki label yang jelas
3. **Tidak Ada Alur Langsung Antar Data Store**: Data store hanya berinteraksi dengan proses
4. **Konsistensi Nomor Proses**: Setiap sub-proses menggunakan format `x.y` dimana `x` adalah nomor proses utama
5. **Input/Output Jelas**: Setiap proses harus memiliki input dan output yang jelas

---

## 1. DFD Level 1 - Login/Register Admin (1.0)

```mermaid
graph TB
    Admin["Admin"]
    
    P11["1.1 Tampilkan<br/>Form Login"]
    P12["1.2 Validasi<br/>Kredensial"]
    P13["1.3 Proses<br/>Login"]
    P14["1.4 Tampilkan<br/>Form Register"]
    P15["1.5 Validasi<br/>Data Register"]
    P16["1.6 Proses<br/>Registrasi"]
    P17["1.7 Tampilkan<br/>Form Reset Password"]
    P18["1.8 Generate<br/>Token Reset"]
    P19["1.9 Kirim Email<br/>Reset Password"]
    P110["1.10 Validasi<br/>Token Reset"]
    P111["1.11 Update<br/>Password"]
    P112["1.12 Proses<br/>Logout"]
    
    D1[("dt_admin_user")]
    D7[("dt_reset_password")]
    D4[("dt_activity_log")]
    
    %% Login Flow
    Admin -->|"data_login"| P11
    P11 -->|"info_login"| Admin
    Admin -->|"username, password"| P12
    P12 -->|"data_login"| D1
    D1 -->|"data_admin_user"| P12
    P12 -->|"kredensial valid"| P13
    P13 -->|"data_admin_user"| D1
    P13 -->|"data_activity"| D4
    D4 -->|"data_activity_log"| P13
    P13 -->|"info_login"| Admin
    
    %% Register Flow
    Admin -->|"data_register"| P14
    P14 -->|"info_register"| Admin
    Admin -->|"name, email, username, password"| P15
    P15 -->|"validasi data"| P16
    P16 -->|"data_admin_user"| D1
    D1 -->|"data_admin_user"| P16
    P16 -->|"data_activity"| D4
    D4 -->|"data_activity_log"| P16
    P16 -->|"info_register"| Admin
    
    %% Reset Password Flow
    Admin -->|"data_reset_password"| P17
    P17 -->|"info_reset_password"| Admin
    Admin -->|"email"| P18
    P18 -->|"data_admin_user"| D1
    D1 -->|"data_admin_user"| P18
    P18 -->|"hapus token lama"| D7
    P18 -->|"data_reset_token"| D7
    D7 -->|"data_token"| P18
    P18 -->|"data email"| P19
    P19 -->|"info_reset_password"| Admin
    
    Admin -->|"token, email, password baru"| P110
    P110 -->|"data_token"| D7
    D7 -->|"data_token"| P110
    P110 -->|"token valid"| P111
    P111 -->|"data_admin_user"| D1
    D1 -->|"data_admin_user"| P111
    P111 -->|"data_admin_user"| D1
    P111 -->|"hapus token"| D7
    P111 -->|"data_activity"| D4
    D4 -->|"data_activity_log"| P111
    P111 -->|"info_reset_password"| Admin
    
    %% Logout Flow
    Admin -->|"request logout"| P112
    P112 -->|"data_activity"| D4
    D4 -->|"data_activity_log"| P112
    P112 -->|"info logout"| Admin
    
    style P11 fill:#E8F4F8,stroke:#2E5C8A,stroke-width:2px,color:#000
    style P12 fill:#E8F4F8,stroke:#2E5C8A,stroke-width:2px,color:#000
    style P13 fill:#E8F4F8,stroke:#2E5C8A,stroke-width:2px,color:#000
    style P14 fill:#E8F4F8,stroke:#2E5C8A,stroke-width:2px,color:#000
    style P15 fill:#E8F4F8,stroke:#2E5C8A,stroke-width:2px,color:#000
    style P16 fill:#E8F4F8,stroke:#2E5C8A,stroke-width:2px,color:#000
    style P17 fill:#E8F4F8,stroke:#2E5C8A,stroke-width:2px,color:#000
    style P18 fill:#E8F4F8,stroke:#2E5C8A,stroke-width:2px,color:#000
    style P19 fill:#E8F4F8,stroke:#2E5C8A,stroke-width:2px,color:#000
    style P110 fill:#E8F4F8,stroke:#2E5C8A,stroke-width:2px,color:#000
    style P111 fill:#E8F4F8,stroke:#2E5C8A,stroke-width:2px,color:#000
    style P112 fill:#E8F4F8,stroke:#2E5C8A,stroke-width:2px,color:#000
    style Admin fill:#fff,stroke:#C92A2A,stroke-width:2px,color:#000
    style D1 fill:#fff,stroke:#6B3483,stroke-width:2px,color:#000
    style D7 fill:#fff,stroke:#6B3483,stroke-width:2px,color:#000
    style D4 fill:#fff,stroke:#6B3483,stroke-width:2px,color:#000
```

**Keterangan Proses:**
- **1.1 Tampilkan Form Login**: Menampilkan form login kepada admin
- **1.2 Validasi Kredensial**: Memvalidasi username dan password dengan database
- **1.3 Proses Login**: Melakukan autentikasi, update last_login_at, dan mencatat activity log
- **1.4 Tampilkan Form Register**: Menampilkan form registrasi admin baru
- **1.5 Validasi Data Register**: Memvalidasi data registrasi (email, username harus unique)
- **1.6 Proses Registrasi**: Membuat akun admin baru dan mencatat activity log
- **1.7 Tampilkan Form Reset Password**: Menampilkan form untuk request reset password
- **1.8 Generate Token Reset**: Membuat token reset password dan menyimpan ke database
- **1.9 Kirim Email Reset Password**: Mengirim email reset password ke admin
- **1.10 Validasi Token Reset**: Memvalidasi token reset password (cek expiry dan validitas)
- **1.11 Update Password**: Mengupdate password admin dan menghapus token yang digunakan
- **1.12 Proses Logout**: Melakukan logout dan mencatat activity log

---

## 2. DFD Level 1 - Manajemen Dokter (2.0)

```mermaid
graph TB
    Admin["Admin"]
    
    P21["2.1 Tampilkan<br/>Daftar Dokter"]
    P22["2.2 Tampilkan<br/>Form Tambah Dokter"]
    P23["2.3 Validasi<br/>Data Dokter"]
    P24["2.4 Upload<br/>Foto Dokter"]
    P25["2.5 Simpan<br/>Data Dokter"]
    P26["2.6 Tampilkan<br/>Form Edit Dokter"]
    P27["2.7 Update<br/>Data Dokter"]
    P28["2.8 Hapus<br/>Foto Lama"]
    P29["2.9 Hapus<br/>Data Dokter"]
    P210["2.10 Catat<br/>Activity Log"]
    
    D2[("dt_dokter")]
    D4[("dt_activity_log")]
    
    %% List Doctors
    Admin -->|"request daftar"| P21
    P21 -->|"data_dokter"| D2
    D2 -->|"data_dokter"| P21
    P21 -->|"info_dokter"| Admin
    
    %% Create Doctor
    Admin -->|"data_dokter"| P22
    P22 -->|"info_dokter"| Admin
    Admin -->|"data_dokter + foto"| P23
    P23 -->|"validasi data"| P24
    P24 -->|"path foto"| P25
    P25 -->|"data_dokter"| D2
    D2 -->|"data_dokter"| P25
    P25 -->|"data_activity"| P210
    P210 -->|"data_activity"| D4
    D4 -->|"data_activity_log"| P210
    P25 -->|"info_dokter"| Admin
    
    %% Edit Doctor
    Admin -->|"request edit"| P26
    P26 -->|"data_dokter"| D2
    D2 -->|"data_dokter"| P26
    P26 -->|"info_dokter"| Admin
    Admin -->|"data_dokter update + foto baru"| P27
    P27 -->|"data_dokter"| D2
    D2 -->|"data_dokter"| P27
    P27 -->|"hapus foto lama"| P28
    P28 -->|"foto lama terhapus"| P27
    P27 -->|"upload foto baru"| P24
    P24 -->|"path foto baru"| P27
    P27 -->|"data_dokter"| D2
    P27 -->|"data_activity"| P210
    P210 -->|"data_activity"| D4
    D4 -->|"data_activity_log"| P210
    P27 -->|"info_dokter"| Admin
    
    %% Delete Doctor
    Admin -->|"request hapus"| P29
    P29 -->|"data_dokter"| D2
    D2 -->|"data_dokter"| P29
    P29 -->|"hapus data"| D2
    P29 -->|"data_activity"| P210
    P210 -->|"data_activity"| D4
    D4 -->|"data_activity_log"| P210
    P29 -->|"info_dokter"| Admin
    
    style P21 fill:#E8F4F8,stroke:#2E5C8A,stroke-width:2px,color:#000
    style P22 fill:#E8F4F8,stroke:#2E5C8A,stroke-width:2px,color:#000
    style P23 fill:#E8F4F8,stroke:#2E5C8A,stroke-width:2px,color:#000
    style P24 fill:#E8F4F8,stroke:#2E5C8A,stroke-width:2px,color:#000
    style P25 fill:#E8F4F8,stroke:#2E5C8A,stroke-width:2px,color:#000
    style P26 fill:#E8F4F8,stroke:#2E5C8A,stroke-width:2px,color:#000
    style P27 fill:#E8F4F8,stroke:#2E5C8A,stroke-width:2px,color:#000
    style P28 fill:#E8F4F8,stroke:#2E5C8A,stroke-width:2px,color:#000
    style P29 fill:#E8F4F8,stroke:#2E5C8A,stroke-width:2px,color:#000
    style P210 fill:#E8F4F8,stroke:#2E5C8A,stroke-width:2px,color:#000
    style Admin fill:#fff,stroke:#C92A2A,stroke-width:2px,color:#000
    style D2 fill:#fff,stroke:#6B3483,stroke-width:2px,color:#000
    style D4 fill:#fff,stroke:#6B3483,stroke-width:2px,color:#000
```

**Keterangan Proses:**
- **2.1 Tampilkan Daftar Dokter**: Menampilkan daftar semua dokter dengan pagination
- **2.2 Tampilkan Form Tambah Dokter**: Menampilkan form untuk menambah dokter baru
- **2.3 Validasi Data Dokter**: Memvalidasi data dokter (name_id, name_en, specialization_id, specialization_en, foto)
- **2.4 Upload Foto Dokter**: Mengupload foto dokter ke file storage
- **2.5 Simpan Data Dokter**: Menyimpan data dokter ke database dan mencatat activity log
- **2.6 Tampilkan Form Edit Dokter**: Menampilkan form edit dengan data dokter yang ada
- **2.7 Update Data Dokter**: Mengupdate data dokter (termasuk foto jika ada)
- **2.8 Hapus Foto Lama**: Menghapus foto lama saat update foto baru
- **2.9 Hapus Data Dokter**: Menghapus data dokter dan foto terkait
- **2.10 Catat Activity Log**: Mencatat semua aktivitas CRUD dokter ke activity log

---

## 3. DFD Level 1 - Manajemen Layanan (3.0)

```mermaid
graph TB
    Admin["Admin"]
    
    P31["3.1 Tampilkan<br/>Daftar Layanan"]
    P32["3.2 Tampilkan<br/>Form Tambah Layanan"]
    P33["3.3 Validasi<br/>Data Layanan"]
    P34["3.4 Upload<br/>Icon Layanan"]
    P35["3.5 Simpan<br/>Data Layanan"]
    P36["3.6 Tampilkan<br/>Form Edit Layanan"]
    P37["3.7 Update<br/>Data Layanan"]
    P38["3.8 Hapus<br/>Icon Lama"]
    P39["3.9 Hapus<br/>Data Layanan"]
    P310["3.10 Catat<br/>Activity Log"]
    
    D3[("dt_services")]
    D4[("dt_activity_log")]
    
    %% List Services
    Admin -->|"request daftar"| P31
    P31 -->|"data_layanan"| D3
    D3 -->|"data_layanan"| P31
    P31 -->|"info_layanan"| Admin
    
    %% Create Service
    Admin -->|"data_layanan"| P32
    P32 -->|"info_layanan"| Admin
    Admin -->|"data_layanan + icon"| P33
    P33 -->|"validasi data"| P34
    P34 -->|"path icon"| P35
    P35 -->|"data_layanan"| D3
    D3 -->|"data_layanan"| P35
    P35 -->|"data_activity"| P310
    P310 -->|"data_activity"| D4
    D4 -->|"data_activity_log"| P310
    P35 -->|"info_layanan"| Admin
    
    %% Edit Service
    Admin -->|"request edit"| P36
    P36 -->|"data_layanan"| D3
    D3 -->|"data_layanan"| P36
    P36 -->|"info_layanan"| Admin
    Admin -->|"data_layanan update + icon baru"| P37
    P37 -->|"data_layanan"| D3
    D3 -->|"data_layanan"| P37
    P37 -->|"hapus icon lama"| P38
    P38 -->|"icon lama terhapus"| P37
    P37 -->|"upload icon baru"| P34
    P34 -->|"path icon baru"| P37
    P37 -->|"data_layanan"| D3
    P37 -->|"data_activity"| P310
    P310 -->|"data_activity"| D4
    D4 -->|"data_activity_log"| P310
    P37 -->|"info_layanan"| Admin
    
    %% Delete Service
    Admin -->|"request hapus"| P39
    P39 -->|"data_layanan"| D3
    D3 -->|"data_layanan"| P39
    P39 -->|"hapus data"| D3
    P39 -->|"data_activity"| P310
    P310 -->|"data_activity"| D4
    D4 -->|"data_activity_log"| P310
    P39 -->|"info_layanan"| Admin
    
    style P31 fill:#E8F4F8,stroke:#2E5C8A,stroke-width:2px,color:#000
    style P32 fill:#E8F4F8,stroke:#2E5C8A,stroke-width:2px,color:#000
    style P33 fill:#E8F4F8,stroke:#2E5C8A,stroke-width:2px,color:#000
    style P34 fill:#E8F4F8,stroke:#2E5C8A,stroke-width:2px,color:#000
    style P35 fill:#E8F4F8,stroke:#2E5C8A,stroke-width:2px,color:#000
    style P36 fill:#E8F4F8,stroke:#2E5C8A,stroke-width:2px,color:#000
    style P37 fill:#E8F4F8,stroke:#2E5C8A,stroke-width:2px,color:#000
    style P38 fill:#E8F4F8,stroke:#2E5C8A,stroke-width:2px,color:#000
    style P39 fill:#E8F4F8,stroke:#2E5C8A,stroke-width:2px,color:#000
    style P310 fill:#E8F4F8,stroke:#2E5C8A,stroke-width:2px,color:#000
    style Admin fill:#fff,stroke:#C92A2A,stroke-width:2px,color:#000
    style D3 fill:#fff,stroke:#6B3483,stroke-width:2px,color:#000
    style D4 fill:#fff,stroke:#6B3483,stroke-width:2px,color:#000
```

**Keterangan Proses:**
- **3.1 Tampilkan Daftar Layanan**: Menampilkan daftar semua layanan dengan sorting berdasarkan sort_order
- **3.2 Tampilkan Form Tambah Layanan**: Menampilkan form untuk menambah layanan baru
- **3.3 Validasi Data Layanan**: Memvalidasi data layanan (name_id, name_en, description_id, description_en, price, icon)
- **3.4 Upload Icon Layanan**: Mengupload icon layanan ke file storage
- **3.5 Simpan Data Layanan**: Menyimpan data layanan ke database dan mencatat activity log
- **3.6 Tampilkan Form Edit Layanan**: Menampilkan form edit dengan data layanan yang ada
- **3.7 Update Data Layanan**: Mengupdate data layanan (termasuk icon jika ada)
- **3.8 Hapus Icon Lama**: Menghapus icon lama saat update icon baru
- **3.9 Hapus Data Layanan**: Menghapus data layanan dan icon terkait
- **3.10 Catat Activity Log**: Mencatat semua aktivitas CRUD layanan ke activity log

---

## 4. DFD Level 1 - Manajemen Konten (4.0)

```mermaid
graph TB
    Admin["Admin"]
    
    P41["4.1 Tampilkan<br/>Daftar Konten"]
    P42["4.2 Tampilkan<br/>Form Edit Konten"]
    P43["4.3 Validasi<br/>Data Konten"]
    P44["4.4 Update<br/>Konten Halaman"]
    P45["4.5 Catat<br/>Activity Log"]
    
    D5[("dt_content_pages")]
    D4[("dt_activity_log")]
    
    %% List Content Pages
    Admin -->|"request daftar"| P41
    P41 -->|"data_konten"| D5
    D5 -->|"data_konten"| P41
    P41 -->|"info_konten"| Admin
    
    %% Edit Content Page
    Admin -->|"request edit"| P42
    P42 -->|"data_konten"| D5
    D5 -->|"data_konten"| P42
    P42 -->|"info_konten"| Admin
    Admin -->|"data_konten update"| P43
    P43 -->|"validasi data"| P44
    P44 -->|"data_konten"| D5
    D5 -->|"data_konten"| P44
    P44 -->|"data_activity"| P45
    P45 -->|"data_activity"| D4
    D4 -->|"data_activity_log"| P45
    P44 -->|"info_konten"| Admin
    
    style P41 fill:#E8F4F8,stroke:#2E5C8A,stroke-width:2px,color:#000
    style P42 fill:#E8F4F8,stroke:#2E5C8A,stroke-width:2px,color:#000
    style P43 fill:#E8F4F8,stroke:#2E5C8A,stroke-width:2px,color:#000
    style P44 fill:#E8F4F8,stroke:#2E5C8A,stroke-width:2px,color:#000
    style P45 fill:#E8F4F8,stroke:#2E5C8A,stroke-width:2px,color:#000
    style Admin fill:#fff,stroke:#C92A2A,stroke-width:2px,color:#000
    style D5 fill:#fff,stroke:#6B3483,stroke-width:2px,color:#000
    style D4 fill:#fff,stroke:#6B3483,stroke-width:2px,color:#000
```

**Keterangan Proses:**
- **4.1 Tampilkan Daftar Konten**: Menampilkan daftar semua konten halaman (about_us, contact, faq) dengan versi ID dan EN
- **4.2 Tampilkan Form Edit Konten**: Menampilkan form edit konten untuk bahasa ID dan EN
- **4.3 Validasi Data Konten**: Memvalidasi data konten (title, content, meta_data untuk setiap locale)
- **4.4 Update Konten Halaman**: Mengupdate konten halaman untuk setiap locale (ID dan EN)
- **4.5 Catat Activity Log**: Mencatat aktivitas update konten ke activity log

---

## 5. DFD Level 1 - Manajemen FAQ (5.0)

```mermaid
graph TB
    Admin["Admin"]
    
    P51["5.1 Tampilkan<br/>Daftar FAQ"]
    P52["5.2 Tampilkan<br/>Form Tambah FAQ"]
    P53["5.3 Validasi<br/>Data FAQ"]
    P54["5.4 Simpan<br/>Data FAQ"]
    P55["5.5 Tampilkan<br/>Form Edit FAQ"]
    P56["5.6 Update<br/>Data FAQ"]
    P57["5.7 Hapus<br/>Data FAQ"]
    P58["5.8 Toggle<br/>Status FAQ"]
    P59["5.9 Catat<br/>Activity Log"]
    
    D6[("dt_faqs")]
    D4[("dt_activity_log")]
    
    %% List FAQs
    Admin -->|"request daftar"| P51
    P51 -->|"data_faq"| D6
    D6 -->|"data_faq"| P51
    P51 -->|"info_faq"| Admin
    
    %% Create FAQ
    Admin -->|"data_faq"| P52
    P52 -->|"info_faq"| Admin
    Admin -->|"data FAQ"| P53
    P53 -->|"validasi data"| P54
    P54 -->|"data_faq"| D6
    D6 -->|"data_faq"| P54
    P54 -->|"data_activity"| P59
    P59 -->|"data_activity"| D4
    D4 -->|"data_activity_log"| P59
    P54 -->|"info_faq"| Admin
    
    %% Edit FAQ
    Admin -->|"request edit"| P55
    P55 -->|"data_faq"| D6
    D6 -->|"data_faq"| P55
    P55 -->|"info_faq"| Admin
    Admin -->|"data FAQ update"| P56
    P56 -->|"data_faq"| D6
    D6 -->|"data_faq"| P56
    P56 -->|"data_faq"| D6
    P56 -->|"data_activity"| P59
    P59 -->|"data_activity"| D4
    D4 -->|"data_activity_log"| P59
    P56 -->|"info_faq"| Admin
    
    %% Delete FAQ (Soft Delete)
    Admin -->|"request hapus"| P57
    P57 -->|"data_faq"| D6
    D6 -->|"data_faq"| P57
    P57 -->|"soft delete"| D6
    P57 -->|"data_activity"| P59
    P59 -->|"data_activity"| D4
    D4 -->|"data_activity_log"| P59
    P57 -->|"info_faq"| Admin
    
    %% Toggle Status
    Admin -->|"request toggle status"| P58
    P58 -->|"data_faq"| D6
    D6 -->|"data_faq"| P58
    P58 -->|"data_faq"| D6
    P58 -->|"data_activity"| P59
    P59 -->|"data_activity"| D4
    D4 -->|"data_activity_log"| P59
    P58 -->|"info_faq"| Admin
    
    style P51 fill:#E8F4F8,stroke:#2E5C8A,stroke-width:2px,color:#000
    style P52 fill:#E8F4F8,stroke:#2E5C8A,stroke-width:2px,color:#000
    style P53 fill:#E8F4F8,stroke:#2E5C8A,stroke-width:2px,color:#000
    style P54 fill:#E8F4F8,stroke:#2E5C8A,stroke-width:2px,color:#000
    style P55 fill:#E8F4F8,stroke:#2E5C8A,stroke-width:2px,color:#000
    style P56 fill:#E8F4F8,stroke:#2E5C8A,stroke-width:2px,color:#000
    style P57 fill:#E8F4F8,stroke:#2E5C8A,stroke-width:2px,color:#000
    style P58 fill:#E8F4F8,stroke:#2E5C8A,stroke-width:2px,color:#000
    style P59 fill:#E8F4F8,stroke:#2E5C8A,stroke-width:2px,color:#000
    style Admin fill:#fff,stroke:#C92A2A,stroke-width:2px,color:#000
    style D6 fill:#fff,stroke:#6B3483,stroke-width:2px,color:#000
    style D4 fill:#fff,stroke:#6B3483,stroke-width:2px,color:#000
```

**Keterangan Proses:**
- **5.1 Tampilkan Daftar FAQ**: Menampilkan daftar semua FAQ termasuk yang soft deleted, dengan sorting berdasarkan sort_order
- **5.2 Tampilkan Form Tambah FAQ**: Menampilkan form untuk menambah FAQ baru
- **5.3 Validasi Data FAQ**: Memvalidasi data FAQ (question_id, question_en, answer_id, answer_en, category, sort_order)
- **5.4 Simpan Data FAQ**: Menyimpan data FAQ ke database dan mencatat activity log
- **5.5 Tampilkan Form Edit FAQ**: Menampilkan form edit dengan data FAQ yang ada
- **5.6 Update Data FAQ**: Mengupdate data FAQ dan mencatat activity log
- **5.7 Hapus Data FAQ**: Melakukan soft delete pada FAQ (mengset deleted_at)
- **5.8 Toggle Status FAQ**: Mengaktifkan/menonaktifkan FAQ dengan mengubah is_active
- **5.9 Catat Activity Log**: Mencatat semua aktivitas CRUD FAQ ke activity log

---

## 6. DFD Level 1 - Tampilan Website (6.0)

```mermaid
graph TB
    User["User"]
    
    P61["6.1 Terima Request<br/>Halaman"]
    P62["6.2 Proses<br/>Bahasa"]
    P63["6.3 Ambil Data<br/>Dokter"]
    P64["6.4 Ambil Data<br/>Layanan"]
    P65["6.5 Ambil Data<br/>FAQ"]
    P66["6.6 Ambil Data<br/>Konten Halaman"]
    P67["6.7 Proses<br/>Kuesioner"]
    P68["6.8 Format Data<br/>Tampilan"]
    P69["6.9 Render<br/>Halaman"]
    
    D2[("dt_dokter")]
    D3[("dt_services")]
    D6[("dt_faqs")]
    D5[("dt_content_pages")]
    D4[("dt_activity_log")]
    
    %% Request Page
    User -->|"data_bahasa, data_kuesioner"| P61
    P61 -->|"data request"| P62
    P62 -->|"set locale"| P63
    P62 -->|"set locale"| P64
    P62 -->|"set locale"| P65
    P62 -->|"set locale"| P66
    
    %% Get Data
    P63 -->|"data_dokter"| D2
    D2 -->|"data_dokter"| P63
    P64 -->|"data_layanan"| D3
    D3 -->|"data_layanan"| P64
    P65 -->|"data_faq"| D6
    D6 -->|"data_faq"| P65
    P66 -->|"data_konten"| D5
    D5 -->|"data_konten"| P66
    
    %% Process Questionnaire
    User -->|"data_kuesioner"| P67
    P67 -->|"section prioritas"| P68
    
    %% Format and Render
    P63 -->|"data_dokter"| P68
    P64 -->|"data_layanan"| P68
    P65 -->|"data_faq"| P68
    P66 -->|"data_konten"| P68
    P68 -->|"data terformat"| P69
    P69 -->|"data_dokter, data_layanan, data_konten, data_faq"| User
    P69 -->|"info_bahasa, info_kuesioner"| User
    
    %% Activity Log
    P69 -->|"data_activity"| D4
    D4 -->|"data_activity_log"| P69
    
    style P61 fill:#E8F4F8,stroke:#2E5C8A,stroke-width:2px,color:#000
    style P62 fill:#E8F4F8,stroke:#2E5C8A,stroke-width:2px,color:#000
    style P63 fill:#E8F4F8,stroke:#2E5C8A,stroke-width:2px,color:#000
    style P64 fill:#E8F4F8,stroke:#2E5C8A,stroke-width:2px,color:#000
    style P65 fill:#E8F4F8,stroke:#2E5C8A,stroke-width:2px,color:#000
    style P66 fill:#E8F4F8,stroke:#2E5C8A,stroke-width:2px,color:#000
    style P67 fill:#E8F4F8,stroke:#2E5C8A,stroke-width:2px,color:#000
    style P68 fill:#E8F4F8,stroke:#2E5C8A,stroke-width:2px,color:#000
    style P69 fill:#E8F4F8,stroke:#2E5C8A,stroke-width:2px,color:#000
    style User fill:#fff,stroke:#2E7D4E,stroke-width:2px,color:#000
    style D2 fill:#fff,stroke:#6B3483,stroke-width:2px,color:#000
    style D3 fill:#fff,stroke:#6B3483,stroke-width:2px,color:#000
    style D6 fill:#fff,stroke:#6B3483,stroke-width:2px,color:#000
    style D5 fill:#fff,stroke:#6B3483,stroke-width:2px,color:#000
    style D4 fill:#fff,stroke:#6B3483,stroke-width:2px,color:#000
```

**Keterangan Proses:**
- **6.1 Terima Request Halaman**: Menerima request dari pengunjung untuk melihat halaman website
- **6.2 Proses Bahasa**: Memproses pemilihan bahasa (ID/EN) dari session atau request
- **6.3 Ambil Data Dokter**: Mengambil data dokter yang aktif dari database
- **6.4 Ambil Data Layanan**: Mengambil data layanan yang aktif dari database (sorted by sort_order)
- **6.5 Ambil Data FAQ**: Mengambil data FAQ yang aktif dari database (sorted by sort_order)
- **6.6 Ambil Data Konten Halaman**: Mengambil konten halaman berdasarkan locale (ID/EN)
- **6.7 Proses Kuesioner**: Memproses kuesioner dari pengunjung untuk menentukan section prioritas
- **6.8 Format Data Tampilan**: Memformat data untuk ditampilkan sesuai dengan locale dan prioritas section
- **6.9 Render Halaman**: Merender halaman website dengan data yang sudah diformat dan mencatat activity log

---

## Mapping Data Store

| Data Store | Nama Tabel | Deskripsi |
|------------|------------|-----------|
| dt_admin_user | admin_users | Menyimpan data admin user |
| dt_dokter | doctors | Menyimpan data dokter |
| dt_services | services | Menyimpan data layanan medis |
| dt_content_pages | content_pages | Menyimpan konten halaman website |
| dt_faqs | faqs | Menyimpan data FAQ |
| dt_activity_log | activity_logs | Menyimpan log aktivitas admin |
| dt_reset_password | admin_password_reset_tokens | Menyimpan token reset password |

---

## Alur Data Utama

### 1. Alur Login Admin
1. Admin mengirim `data_login` ke P1.1
2. P1.1 menampilkan form login
3. Admin mengirim `username, password` ke P1.2
4. P1.2 memvalidasi dengan dt_admin_user
5. Jika valid, P1.3 melakukan login dan update dt_admin_user, catat ke dt_activity_log
6. P1.3 mengirim `info_login` ke Admin

### 2. Alur Tambah Dokter
1. Admin mengirim `data_dokter` ke P2.2
2. P2.2 menampilkan form
3. Admin mengirim `data_dokter + foto` ke P2.3
4. P2.3 memvalidasi, P2.4 upload foto
5. P2.5 menyimpan data ke dt_dokter, catat ke dt_activity_log
6. P2.5 mengirim `info_dokter` ke Admin

### 3. Alur Tampilan Website
1. User mengirim `data_bahasa, data_kuesioner` ke P6.1
2. P6.2 memproses bahasa dan set locale
3. P6.3, P6.4, P6.5, P6.6 mengambil data dari dt_dokter, dt_services, dt_faqs, dt_content_pages
4. P6.7 memproses kuesioner jika ada
5. P6.8 memformat data sesuai locale dan prioritas
6. P6.9 merender halaman dan mengirim ke User, catat ke dt_activity_log

---

**Dibuat**: 2024  
**Versi**: 1.0  
**Sistem**: Legian Medical Clinic Website CMS


