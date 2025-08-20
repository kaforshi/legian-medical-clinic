<!DOCTYPE html>
{{-- Mengatur bahasa dokumen berdasarkan locale aplikasi --}}
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Legian Medical Clinic - Pelayanan Kesehatan Terpercaya</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body class="bg-light text-dark" data-prioritized="{{ $prioritizedSection ?? '' }}">

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
    <script src="{{ asset('js/script.js') }}"></script>
    
    {{-- Script langsung untuk memastikan modal kuesioner muncul --}}
    <script>
        // Script langsung untuk modal kuesioner
        document.addEventListener('DOMContentLoaded', function() {
            console.log('Direct script: DOM loaded');
            
            // Cek apakah kuesioner sudah dijawab
            const answered = sessionStorage.getItem('questionnaireAnswered');
            console.log('Direct script: Questionnaire answered:', answered);
            
            if (!answered) {
                console.log('Direct script: Will show questionnaire in 2 seconds...');
                
                setTimeout(function() {
                    const modal = document.getElementById('questionnaireModal');
                    if (modal) {
                        console.log('Direct script: Modal found, showing...');
                        
                        if (typeof bootstrap !== 'undefined') {
                            try {
                                const bootstrapModal = new bootstrap.Modal(modal);
                                bootstrapModal.show();
                                console.log('Direct script: Modal shown with Bootstrap');
                            } catch (error) {
                                console.error('Direct script: Bootstrap error:', error);
                                // Fallback CSS
                                modal.style.display = 'block';
                                modal.classList.add('show');
                                document.body.classList.add('modal-open');
                            }
                        } else {
                            console.log('Direct script: Bootstrap not available, using CSS');
                            modal.style.display = 'block';
                            modal.classList.add('show');
                            document.body.classList.add('modal-open');
                        }
                    } else {
                        console.error('Direct script: Modal element not found!');
                    }
                }, 2000);
            } else {
                console.log('Direct script: Questionnaire already answered, skipping');
            }
            
            // Setup event handler untuk tombol skip
            setupSkipButtonHandler();
        });
        
        // Fallback jika DOMContentLoaded tidak terpanggil
        window.addEventListener('load', function() {
            console.log('Direct script: Window loaded');
            
            const answered = sessionStorage.getItem('questionnaireAnswered');
            if (!answered) {
                setTimeout(function() {
                    const modal = document.getElementById('questionnaireModal');
                    if (modal) {
                        if (typeof bootstrap !== 'undefined') {
                            const bootstrapModal = new bootstrap.Modal(modal);
                            bootstrapModal.show();
                        } else {
                            modal.style.display = 'block';
                            modal.classList.add('show');
                            document.body.classList.add('modal-open');
                        }
                    }
                }, 1000);
            }
            
            // Setup event handler untuk tombol skip
            setupSkipButtonHandler();
        });
        
        // Fungsi untuk setup event handler tombol skip
        function setupSkipButtonHandler() {
            const skipButton = document.querySelector('#questionnaireModal button[data-bs-dismiss="modal"]');
            if (skipButton) {
                skipButton.addEventListener('click', function() {
                    console.log('Skip button clicked');
                    
                    // Simpan status bahwa kuesioner sudah dijawab
                    sessionStorage.setItem('questionnaireAnswered', 'true');
                    
                    // Hapus backdrop dan class modal-open jika ada
                    cleanupModalBackdrop();
                    
                    console.log('Questionnaire skipped and cleaned up');
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
            
            console.log('Modal backdrop cleaned up and scrolling restored');
        }
        
        // Event listener untuk modal hidden event (Bootstrap)
        document.addEventListener('DOMContentLoaded', function() {
            const modal = document.getElementById('questionnaireModal');
            if (modal) {
                modal.addEventListener('hidden.bs.modal', function() {
                    console.log('Modal hidden event triggered');
                    cleanupModalBackdrop();
                });
            }
        });
    </script>
</body>
</html>