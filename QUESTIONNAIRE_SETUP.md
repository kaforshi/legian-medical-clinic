# Fitur Kuesioner - Legian Medical Clinic

## Overview
Website Legian Medical Clinic memiliki fitur kuesioner yang muncul otomatis saat pertama kali user mengakses website. Kuesioner ini membantu user menemukan informasi yang mereka cari dengan cepat.

## Fitur yang Tersedia
- **Modal Kuesioner**: Muncul otomatis saat pertama kali website dibuka
- **4 Pilihan Pertanyaan**: Setiap pilihan mengarahkan ke section yang relevan
- **Skip Option**: User bisa melewati kuesioner jika tidak ingin menjawab
- **Section Prioritization**: Section yang dipilih akan muncul tepat di bawah hero section
- **Session Memory**: Kuesioner hanya muncul sekali per session

## Cara Kerja
1. **Auto-Show**: Modal kuesioner muncul otomatis setelah 1 detik
2. **User Choice**: User memilih salah satu dari 4 opsi atau skip
3. **Redirect**: Jika user memilih opsi, mereka diarahkan ke section yang relevan
4. **Section Reorder**: Section yang dipilih akan muncul di posisi pertama (setelah hero)
5. **Session Storage**: Status kuesioner disimpan di sessionStorage browser

## Opsi Kuesioner
| Opsi | Deskripsi | Redirect ke | Section |
|------|-----------|-------------|---------|
| **Q1** | Official contact of Legian Medical Clinic | `/contact` | Contact |
| **Q2** | Location of Legian Medical Clinic | `/contact` | Contact |
| **Q3** | Information about Legian Medical Clinic | `/about` | About |
| **Q4** | Services provided by Legian Medical Clinic | `/services` | Services |

## Struktur File
```
resources/views/
├── partials/
│   └── _questionnaire_modal.blade.php    # Modal kuesioner
└── layouts/
    └── app.blade.php                      # Layout utama (include modal)

public/
├── js/
│   └── script.js                          # JavaScript untuk kuesioner
└── css/
    └── style.css                          # CSS untuk styling modal

app/Http/
└── Controllers/
    └── PageController.php                 # Controller untuk reorder section
```

## Cara Penggunaan
1. **Buka Website**: Akses website Legian Medical Clinic
2. **Modal Muncul**: Kuesioner akan muncul otomatis setelah 1 detik
3. **Pilih Opsi**: Klik salah satu dari 4 opsi yang tersedia
4. **Lihat Hasil**: Section yang dipilih akan muncul tepat di bawah hero
5. **Skip**: Klik "Skip & see all" jika tidak ingin menjawab

## Testing
Untuk memverifikasi fitur kuesioner berfungsi:

### **1. Halaman Test HTML:**
- Akses: `http://localhost:8000/test-questionnaire.html`
- Fitur: Instruksi lengkap dan tools untuk testing

### **2. Test Manual:**
- Buka website utama
- Modal kuesioner harus muncul otomatis
- Test setiap opsi kuesioner
- Test tombol skip

### **3. Reset Kuesioner:**
- Gunakan halaman test untuk clear sessionStorage
- Atau buka Developer Tools → Application → Session Storage → Clear

## Troubleshooting
Jika fitur kuesioner tidak berfungsi:

1. **Periksa Console**: Lihat error di browser console
2. **Periksa Bootstrap**: Pastikan Bootstrap JS sudah dimuat
3. **Periksa SessionStorage**: Pastikan tidak ada masalah dengan browser storage
4. **Periksa Modal Element**: Pastikan element `#questionnaireModal` ada di DOM

## Konfigurasi
- **Auto-show Delay**: 1 detik (1000ms)
- **Backdrop**: Static (tidak bisa ditutup dengan klik luar)
- **Keyboard**: Disabled (tidak bisa ditutup dengan ESC)
- **Session Storage Key**: 'questionnaireAnswered'

## Dependencies
- Bootstrap 5.3.3 (Modal, CSS, JS)
- Font Awesome 6.4.0 (Icons)
- Inter Font (Typography)
- Custom CSS (Styling)
- Custom JavaScript (Functionality)

## Status Fitur
**✅ FITUR KUESIONER SUDAH BERFUNGSI DENGAN BAIK!**

- Modal muncul otomatis saat pertama kali website dibuka
- 4 opsi kuesioner berfungsi dengan baik
- Section prioritization berfungsi
- Session memory berfungsi
- Styling dan animasi sudah optimal
