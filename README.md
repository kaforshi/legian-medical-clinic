# Legian Medical Clinic

Website medical clinic dengan CMS untuk mengelola konten.

## Fitur

- ✅ Admin Panel untuk Content Management
- ✅ Doctor Management
- ✅ Service Management
- ✅ FAQ Management (Multi-locale)
- ✅ Content Pages (Multi-locale)
- ✅ Activity Logging
- ✅ Bahasa Indonesia & English
- ✅ Dynamic Content Prioritization

## Dokumentasi Lengkap

Dokumentasi lengkap tersedia di folder `docs/`:

- **[README.md](docs/README.md)** - Overview dokumentasi
- **[CONTEXT_DIAGRAM.md](docs/CONTEXT_DIAGRAM.md)** - Diagram Konteks Sistem (DFD Level 0)
- **[DFD_LEVEL1.md](docs/DFD_LEVEL1.md)** - Data Flow Diagram Level 1
- **[ERD.md](docs/ERD.md)** - Entity Relationship Diagram
- **[DFD.md](docs/DFD.md)** - Data Flow Diagram
- **[DATABASE_SCHEMA.md](docs/DATABASE_SCHEMA.md)** - Database schema detail
- **[SYSTEM_DIAGRAM.md](docs/SYSTEM_DIAGRAM.md)** - System architecture
- **[EXECUTIVE_SUMMARY.md](docs/EXECUTIVE_SUMMARY.md)** - Ringkasan eksekutif
- **[context-diagram.html](docs/context-diagram.html)** - Interactive Context Diagram viewer (buka di browser)
- **[view-diagrams.html](docs/view-diagrams.html)** - Interactive diagram viewer (buka di browser)

## Quick Start

```bash
# Install dependencies
composer install

# Setup environment
cp .env.example .env
php artisan key:generate

# Run migrations
php artisan migrate

# Seed database
php artisan db:seed

# Link storage
php artisan storage:link

# Run development server
php artisan serve
```

## Admin Login

- URL: `/admin/login`
- Default credentials: Check `database/seeders/AdminUserSeeder.php`

## Teknologi

- Laravel 11 (PHP)
- MySQL Database
- Blade Templates
- Bootstrap CSS

## Struktur Database

Sistem menggunakan 7 tables:
- admin_users
- doctors
- services
- content_pages
- faqs
- activity_logs
- sessions

Detail lengkap: [DATABASE_SCHEMA.md](docs/DATABASE_SCHEMA.md)

---

© 2024 Legian Medical Clinic