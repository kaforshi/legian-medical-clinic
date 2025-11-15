<div class="modal fade" id="questionnaireModal" tabindex="-1" aria-labelledby="questionnaireModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content questionnaire-modal-content shadow-lg border-0">
            {{-- Close Button --}}
            <button type="button" class="btn-close questionnaire-close-btn" data-bs-dismiss="modal" aria-label="Close"></button>
            
            {{-- Logo LMC --}}
            <div class="questionnaire-logo-container">
                <img src="{{ asset('images/lmc.png') }}" alt="Legian Medical Clinic Logo" class="questionnaire-logo-img">
            </div>
            
            <div class="modal-body p-4 p-md-5">
                {{-- Title --}}
                <h2 class="questionnaire-title text-center fw-bold mb-3" id="questionnaireModalLabel">{{ __('messages.questionnaireTitle') }}</h2>
                
                {{-- Subtitle --}}
                <p class="questionnaire-subtitle text-center text-muted mb-4">{{ __('messages.questionnaireSubtitle') }}</p>
                
                {{-- Language Switcher --}}
                <div class="questionnaire-language-switcher-wrapper mb-4">
                    <button class="btn questionnaire-lang-btn" type="button" id="questionnaire-lang-switcher-btn" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-globe"></i>
                        <span class="questionnaire-lang-text">{{ app()->getLocale() === 'id' ? 'Indonesia (ID)' : 'English (EN)' }}</span>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end questionnaire-lang-dropdown" aria-labelledby="questionnaire-lang-switcher-btn">
                        <li>
                            <a class="dropdown-item" href="#" onclick="changeLanguage('id'); return false;">
                                <span>Indonesia (ID)</span>
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="#" onclick="changeLanguage('en'); return false;">
                                <span>English (EN)</span>
                            </a>
                        </li>
                    </ul>
                </div>
                
                {{-- Question Buttons Grid 2x2 --}}
                <form id="questionnaireForm" method="POST" action="{{ route('questionnaire.submit') }}">
                    @csrf
                    <div class="questionnaire-buttons-grid">
                        {{-- Kontak Resmi --}}
                        <button type="button" name="section" value="contact" class="questionnaire-btn questionnaire-btn-contact">
                            <i class="fas fa-phone questionnaire-btn-icon"></i>
                            <span class="questionnaire-btn-text">{{ __('messages.q1') }}</span>
                        </button>
                        
                        {{-- Lokasi Klinik --}}
                        <button type="button" name="section" value="contact" class="questionnaire-btn questionnaire-btn-location">
                            <i class="fas fa-map-marker-alt questionnaire-btn-icon"></i>
                            <span class="questionnaire-btn-text">{{ __('messages.q2') }}</span>
                        </button>
                        
                        {{-- Informasi Klinik --}}
                        <button type="button" name="section" value="about" class="questionnaire-btn questionnaire-btn-info">
                            <i class="fas fa-info-circle questionnaire-btn-icon"></i>
                            <span class="questionnaire-btn-text">{{ __('messages.q3') }}</span>
                        </button>
                        
                        {{-- Layanan Kami --}}
                        <button type="button" name="section" value="services" class="questionnaire-btn questionnaire-btn-services">
                            <i class="fas fa-heartbeat questionnaire-btn-icon"></i>
                            <span class="questionnaire-btn-text">{{ __('messages.q4') }}</span>
                        </button>
                    </div>
                </form>
                
                {{-- Skip Link --}}
                <div class="text-center mt-4">
                    <button type="button" class="btn btn-link questionnaire-skip-link" data-bs-dismiss="modal">
                        {{ __('messages.skipButton') }}
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- JavaScript untuk language switcher --}}
<script>
function changeLanguage(lang) {
    // Update language button text immediately for better UX
    const langTextSpan = document.querySelector('.questionnaire-lang-text');
    if (langTextSpan) {
        langTextSpan.textContent = lang === 'id' ? 'Indonesia (ID)' : 'English (EN)';
    }
    
    // Update language switcher di navbar juga
    const navbarLangCode = document.querySelector('.btn-language-switcher .lang-code');
    if (navbarLangCode) {
        navbarLangCode.textContent = lang.toUpperCase();
    }
    
    // Panggil changeWebsiteLanguage untuk mengubah bahasa seluruh website
    // Fungsi ini akan mengupdate semua konten termasuk modal kuesioner
    if (typeof changeWebsiteLanguage === 'function') {
        changeWebsiteLanguage(lang).catch(error => {
            console.error('Error changing website language:', error);
            // Fallback: update modal content only
            reloadModalContent(lang);
        });
    } else {
        // Fallback jika changeWebsiteLanguage belum tersedia
        // Store language preference in localStorage
        localStorage.setItem('preferredLanguage', lang);
        
        // Send AJAX request to change language
        fetch(`/lang/${lang}`, {
            method: 'GET',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Update document lang attribute
                document.documentElement.lang = lang;
                
                // Reload modal content with new language
                reloadModalContent(lang);
            }
        })
        .catch(error => {
            console.error('Error changing language:', error);
            // Fallback: update content without server response
            reloadModalContent(lang);
        });
    }
}

function showLanguageChangeMessage(lang) {
    const langNames = {
        'id': 'Bahasa Indonesia',
        'en': 'English'
    };
    
    // Create temporary success message
    const message = document.createElement('div');
    message.className = 'alert alert-success alert-dismissible fade show position-fixed';
    message.style.cssText = 'top: 20px; right: 20px; z-index: 9999; min-width: 300px;';
    message.innerHTML = `
        <i class="fas fa-check-circle me-2"></i>
        <strong>${langNames[lang]}</strong> telah dipilih
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    `;
    
    document.body.appendChild(message);
    
    // Auto remove after 3 seconds
    setTimeout(() => {
        if (message.parentNode) {
            message.remove();
        }
    }, 3000);
}

function reloadModalContent(lang) {
    // Update modal content based on selected language
    const modal = document.getElementById('questionnaireModal');
    
    // Update title
    const titleElement = modal.querySelector('#questionnaireModalLabel');
    if (titleElement) {
        titleElement.textContent = getLocalizedText('questionnaireTitle', lang);
    }
    
    // Update subtitle
    const subtitleElement = modal.querySelector('.questionnaire-subtitle');
    if (subtitleElement) {
        subtitleElement.textContent = getLocalizedText('questionnaireSubtitle', lang);
    }
    
    // Update buttons text (keep icons, only update text)
    const buttons = modal.querySelectorAll('.questionnaire-btn');
    const buttonTexts = ['q1', 'q2', 'q3', 'q4'];
    
    buttons.forEach((button, index) => {
        const textSpan = button.querySelector('.questionnaire-btn-text');
        if (textSpan) {
            textSpan.textContent = getLocalizedText(buttonTexts[index], lang);
        }
    });
    
    // Update skip button
    const skipButton = modal.querySelector('.questionnaire-skip-link');
    if (skipButton) {
        skipButton.textContent = getLocalizedText('skipButton', lang);
    }
}

function getLocalizedText(key, lang) {
    // Localized text mapping
    const texts = {
        'id': {
            'questionnaireTitle': 'Selamat Datang di Legian Medical Clinic!',
            'questionnaireSubtitle': 'Untuk membantu Anda lebih cepat, informasi apa yang sedang Anda cari?',
            'q1': 'Kontak Resmi',
            'q2': 'Lokasi Klinik',
            'q3': 'Informasi Klinik',
            'q4': 'Layanan Kami',
            'skipButton': 'Lewati & lihat semua'
        },
        'en': {
            'questionnaireTitle': 'Welcome to Legian Medical Clinic!',
            'questionnaireSubtitle': 'To help you faster, what information are you looking for?',
            'q1': 'Official Contact',
            'q2': 'Clinic Location',
            'q3': 'Clinic Information',
            'q4': 'Our Services',
            'skipButton': 'Skip & see all'
        }
    };
    
    return texts[lang]?.[key] || texts['en'][key] || key;
}

// Handle questionnaire button clicks with AJAX
document.addEventListener('DOMContentLoaded', function() {
    const questionnaireButtons = document.querySelectorAll('.questionnaire-btn');
    questionnaireButtons.forEach(button => {
        button.addEventListener('click', function() {
            const section = this.value;
            const button = this;
            
            // Show loading
            const originalHTML = button.innerHTML;
            const textSpan = button.querySelector('.questionnaire-btn-text');
            const originalText = textSpan ? textSpan.textContent : '';
            button.disabled = true;
            if (textSpan) {
                textSpan.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Memproses...';
            }
            
            // Submit via AJAX
            axios.post('{{ route("questionnaire.submit") }}', {
                section: section
            }, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            })
            .then(response => {
                if (response.data.success) {
                    // Set flag bahwa kuesioner baru saja dijawab
                    sessionStorage.setItem('justAnswered', 'true');
                    
                    // Close modal
                    const modal = bootstrap.Modal.getInstance(document.getElementById('questionnaireModal'));
                    if (modal) {
                        modal.hide();
                    }
                    
                    // Show success message
                    if (typeof showToast === 'function') {
                        showToast('Kuesioner berhasil disubmit!', 'success');
                    }
                    
                    // Reload page to show prioritized section after short delay
                    // Tambahkan parameter untuk mencegah kuesioner muncul di reload ini
                    setTimeout(() => {
                        window.location.href = window.location.pathname + '?answered=1';
                    }, 800);
                } else {
                    button.disabled = false;
                    const textSpan = button.querySelector('.questionnaire-btn-text');
                    if (textSpan) {
                        textSpan.textContent = originalText;
                    }
                    if (typeof showToast === 'function') {
                        showToast('Terjadi kesalahan saat memproses kuesioner.', 'error');
                    }
                }
            })
            .catch(error => {
                console.error('Error submitting questionnaire:', error);
                button.disabled = false;
                const textSpan = button.querySelector('.questionnaire-btn-text');
                if (textSpan) {
                    textSpan.textContent = originalText;
                }
                if (typeof showToast === 'function') {
                    showToast('Terjadi kesalahan saat memproses kuesioner.', 'error');
                } else {
                    alert('Terjadi kesalahan saat memproses kuesioner.');
                }
            });
        });
    });
    
    // Restore language preference when modal opens
    const savedLang = localStorage.getItem('preferredLanguage');
    if (savedLang && (savedLang === 'id' || savedLang === 'en')) {
        // Update language button text
        const langTextSpan = document.querySelector('.questionnaire-lang-text');
        if (langTextSpan) {
            langTextSpan.textContent = savedLang === 'id' ? 'Indonesia (ID)' : 'English (EN)';
        }
        
        // Update content if different from current locale
        const currentLang = '{{ app()->getLocale() }}';
        if (savedLang !== currentLang) {
            reloadModalContent(savedLang);
        }
    }
});
</script>