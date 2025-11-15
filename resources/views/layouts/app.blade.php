<!DOCTYPE html>
{{-- Mengatur bahasa dokumen berdasarkan locale aplikasi --}}
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Legian Medical Clinic - Pelayanan Kesehatan Terpercaya</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body class="bg-light text-dark">

    {{-- Memanggil modal kuesioner --}}
    @include('partials._questionnaire_modal')

    {{-- Memanggil Navbar --}}
    @include('partials._navbar')

    <main>
        {{-- Konten utama halaman akan dimuat di sini --}}
        @yield('content')
    </main>

    {{-- Memanggil Footer --}}
    @include('partials._footer')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="{{ asset('js/ajax-utils.js') }}"></script>
    <script src="{{ asset('js/language-switcher.js') }}"></script>
    <script src="{{ asset('js/script.js') }}"></script>
    
    {{-- Script untuk modal kuesioner --}}
    <script>
        // Script untuk modal kuesioner
        document.addEventListener('DOMContentLoaded', function() {
            // Cek apakah kuesioner baru saja dijawab (dari URL parameter atau sessionStorage)
            const urlParams = new URLSearchParams(window.location.search);
            const justAnswered = urlParams.get('answered') === '1' || sessionStorage.getItem('justAnswered') === 'true';
            
            // Jika baru saja dijawab, jangan tampilkan kuesioner di reload ini
            if (justAnswered) {
                sessionStorage.removeItem('justAnswered'); // Clear flag
                // Remove answered parameter from URL
                if (urlParams.has('answered')) {
                    urlParams.delete('answered');
                    const newUrl = window.location.pathname + (urlParams.toString() ? '?' + urlParams.toString() : '');
                    window.history.replaceState({}, '', newUrl);
                }
                return;
            }
            
            // Reset layout saat refresh: Clear priority section jika tidak ada parameter answered
            // Ini memastikan layout kembali ke default saat refresh normal
            if (!urlParams.has('answered')) {
                axios.post('/clear-priority', {}, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                })
                .catch(error => {
                    // Silent fail - tidak perlu log error
                });
            }
            
            // Kuesioner akan muncul setiap kali halaman di-refresh (kecuali setelah baru dijawab)
            setTimeout(function() {
                const modal = document.getElementById('questionnaireModal');
                if (modal) {
                    if (typeof bootstrap !== 'undefined') {
                        try {
                            const bootstrapModal = new bootstrap.Modal(modal);
                            bootstrapModal.show();
                        } catch (error) {
                            // Fallback CSS
                            modal.style.display = 'block';
                            modal.classList.add('show');
                            document.body.classList.add('modal-open');
                        }
                    } else {
                        // Fallback CSS
                        modal.style.display = 'block';
                        modal.classList.add('show');
                        document.body.classList.add('modal-open');
                    }
                }
            }, 2000);
            
            // Setup event handler untuk tombol skip
            setupSkipButtonHandler();
            
            // Setup event handler untuk form submission
            setupQuestionnaireFormHandler();
        });
        
        // Fungsi untuk setup event handler tombol skip
        function setupSkipButtonHandler() {
            const skipButton = document.querySelector('#questionnaireModal button[data-bs-dismiss="modal"]');
            if (skipButton) {
                skipButton.addEventListener('click', function() {
                    // Set flag bahwa kuesioner baru saja di-skip
                    sessionStorage.setItem('justAnswered', 'true');
                    
                    // Reset layout: Clear priority section via AJAX
                    axios.post('/clear-priority', {}, {
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        }
                    })
                    .then(response => {
                        // Reload halaman untuk memastikan layout benar-benar reset
                        window.location.reload();
                    })
                    .catch(error => {
                        // Tetap reload meskipun ada error
                        window.location.reload();
                    });
                });
            }
        }
        
        // Fungsi untuk membersihkan backdrop modal
        function cleanupModalBackdrop() {
            // Hapus backdrop Bootstrap
            const backdrops = document.querySelectorAll('.modal-backdrop');
            backdrops.forEach(backdrop => {
                backdrop.remove();
            });
            
            // Hapus class modal-open dari body
            document.body.classList.remove('modal-open');
            
            // Hapus class show dari modal
            const modal = document.getElementById('questionnaireModal');
            if (modal) {
                modal.classList.remove('show');
                modal.style.display = 'none';
            }
            
            // Pastikan scrolling berfungsi normal
            document.body.style.overflow = '';
            document.body.style.paddingRight = '';
            document.documentElement.style.overflow = '';
        }
        
        // Fungsi untuk setup event handler form kuesioner
        function setupQuestionnaireFormHandler() {
            const form = document.getElementById('questionnaireForm');
            if (form) {
                form.addEventListener('submit', function(e) {
                    // Tidak perlu menyimpan status, karena kuesioner akan muncul lagi saat refresh
                    // Biarkan form submit secara normal
                });
            }
        }
        
        // Fungsi untuk clear questionnaire status (untuk testing)
        window.clearQuestionnaireStatus = function() {
            sessionStorage.removeItem('questionnaireAnswered');
        };
        
        // Event listener untuk modal hidden event (Bootstrap)
        document.addEventListener('DOMContentLoaded', function() {
            const modal = document.getElementById('questionnaireModal');
            if (modal) {
                modal.addEventListener('hidden.bs.modal', function() {
                    cleanupModalBackdrop();
                });
            }
        });
    </script>
</body>
</html>

