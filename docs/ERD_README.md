# Entity Relationship Diagram (ERD)
## Sistem Website Legian Medical Clinic

### Format Chen Notation

ERD ini dibuat menggunakan format Chen Notation yang menampilkan:
- **Entitas** sebagai kotak (rectangle) - berwarna biru
- **Atribut** sebagai oval (ellipse) - berwarna kuning
- **Relasi** sebagai diamond (rhombus) - berwarna ungu
- **Kardinalitas** ditampilkan dengan angka (1, N)

### Cara Membuka ERD

1. Buka file `ERD_DRAWIO.drawio` menggunakan:
   - **Draw.io Desktop**: Unduh dari https://github.com/jgraph/drawio-desktop/releases
   - **Draw.io Online**: Buka https://app.diagrams.net/ dan pilih "Open Existing Diagram", lalu pilih file `ERD_DRAWIO.drawio`
   - **VS Code**: Install extension "Draw.io Integration" dan buka file `.drawio`

2. Setelah dibuka, Anda dapat:
   - Mengedit posisi entitas, atribut, dan relasi
   - Menambahkan atau menghapus elemen
   - Mengubah warna dan style
   - Menyimpan perubahan

### Entitas dalam ERD

1. **ADMIN_USERS** - Data admin yang memiliki akses ke admin panel
2. **DOCTORS** - Data dokter yang bekerja di klinik
3. **SERVICES** - Data layanan yang ditawarkan klinik
4. **FAQS** - Frequently Asked Questions
5. **CONTENT_PAGES** - Konten halaman website (multilingual)
6. **HERO_SLIDES** - Slide hero di homepage
7. **ACTIVITY_LOGS** - Log aktivitas admin
8. **SESSIONS** - Session Laravel
9. **ADMIN_PASSWORD_RESET_TOKENS** - Token reset password admin

### Relasi

1. **ADMIN_USERS → ACTIVITY_LOGS** (1:N)
   - Relasi: "melakukan aksi"
   - Satu admin dapat melakukan banyak aktivitas

2. **ADMIN_USERS → SESSIONS** (1:N)
   - Relasi: "memiliki sesi"
   - Satu admin dapat memiliki banyak session

3. **ADMIN_USERS → ADMIN_PASSWORD_RESET_TOKENS** (1:1)
   - Relasi: "memiliki token reset"
   - Satu admin memiliki satu token reset password

### Catatan

- ERD ini menggunakan format Chen Notation yang lebih detail dengan menampilkan semua atribut sebagai oval terpisah
- Untuk melihat ERD dalam format Mermaid (lebih ringkas), lihat file `ERD.md`
- File Draw.io dapat diedit dan disesuaikan sesuai kebutuhan

---

© 2024 Legian Medical Clinic

