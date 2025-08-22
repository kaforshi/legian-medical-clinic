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
    <script src="{{ asset('js/script.js') }}"></script>
    
    {{-- Script untuk modal kuesioner --}}
    <script>
        // Script untuk modal kuesioner
        document.addEventListener('DOMContentLoaded', function() {
            console.log('Direct script: DOM loaded');
            
            // Cek apakah kuesioner sudah dijawab dari session dan sessionStorage
            const sessionAnswered = {{ session('questionnaireAnswered') ? 'true' : 'false' }};
            const flashAnswered = {{ session()->has('questionnaireAnswered') ? 'true' : 'false' }};
            const storageAnswered = sessionStorage.getItem('questionnaireAnswered');
            const answered = sessionAnswered === 'true' || flashAnswered === 'true' || storageAnswered === 'true';
            
            console.log('Direct script: Session answered:', sessionAnswered);
            console.log('Direct script: Flash answered:', flashAnswered);
            console.log('Direct script: Storage answered:', storageAnswered);
            console.log('Direct script: Final answered status:', answered);
            
            // Jika session mengatakan sudah dijawab, simpan juga ke sessionStorage
            if (sessionAnswered === 'true' || flashAnswered === 'true') {
                sessionStorage.setItem('questionnaireAnswered', 'true');
                console.log('Direct script: Synced session/flash to sessionStorage');
            }
            
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
            
            // Setup event handler untuk form submission
            setupQuestionnaireFormHandler();
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
        
        // Fungsi untuk setup event handler form kuesioner
        function setupQuestionnaireFormHandler() {
            const form = document.getElementById('questionnaireForm');
            if (form) {
                form.addEventListener('submit', function(e) {
                    console.log('Questionnaire form submitted');
                    
                    // Simpan status bahwa kuesioner sudah dijawab
                    sessionStorage.setItem('questionnaireAnswered', 'true');
                    
                    // Biarkan form submit secara normal
                    console.log('Form will submit normally');
                });
            }
        }
        
        // Fungsi untuk clear questionnaire status (untuk testing)
        window.clearQuestionnaireStatus = function() {
            sessionStorage.removeItem('questionnaireAnswered');
            console.log('Questionnaire status cleared from sessionStorage');
        };
        
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

