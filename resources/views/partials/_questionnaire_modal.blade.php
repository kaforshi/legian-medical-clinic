<div class="modal fade" id="questionnaireModal" tabindex="-1" aria-labelledby="questionnaireModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content shadow-lg border-0">
            {{-- Language Switcher Header --}}
            <div class="modal-header border-0 pb-0 d-flex justify-content-center">
                <div class="language-switcher">
                    <select id="questionnaire-language-switcher" class="form-select form-select-sm" onchange="changeLanguage(this.value)">
                        <option value="id" {{ app()->getLocale() === 'id' ? 'selected' : '' }}>
                            🇮🇩 Indonesia (ID)
                        </option>
                        <option value="en" {{ app()->getLocale() === 'en' ? 'selected' : '' }}>
                            🇺🇸 English (EN)
                        </option>
                    </select>
                </div>
            </div>
            <div class="modal-body p-4 p-md-5 text-center">
                <h2 class="modal-title fw-bold mb-3" id="questionnaireModalLabel">{{ __('messages.questionnaireTitle') }}</h2>
                <p class="text-muted mb-4">{{ __('messages.questionnaireSubtitle') }}</p>
                <form id="questionnaireForm" method="GET" action="{{ route('home') }}">
                    <div class="d-grid gap-3">
                        {{-- Tombol untuk kontak resmi --}}
                        <button type="submit" name="section" value="contact" class="btn btn-primary btn-lg text-center p-3">{{ __('messages.q1') }}</button>
                        {{-- Tombol untuk lokasi --}}
                        <button type="submit" name="section" value="contact" class="btn btn-primary btn-lg text-center p-3">{{ __('messages.q2') }}</button>
                        {{-- Tombol untuk informasi --}}
                        <button type="submit" name="section" value="about" class="btn btn-primary btn-lg text-center p-3">{{ __('messages.q3') }}</button>
                        {{-- Tombol untuk layanan --}}
                        <button type="submit" name="section" value="services" class="btn btn-primary btn-lg text-center p-3">{{ __('messages.q4') }}</button>
                    </div>
                </form>
                <button type="button" class="btn btn-link mt-4" data-bs-dismiss="modal">{{ __('messages.skipButton') }}</button>
            </div>
        </div>
    </div>
</div>

{{-- JavaScript untuk language switcher --}}
<script>
function changeLanguage(lang) {
    // Update dropdown selection
    const dropdown = document.getElementById('questionnaire-language-switcher');
    if (dropdown) {
        dropdown.value = lang;
    }
    
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
            // Reload modal content with new language
            reloadModalContent(lang);
            
            // Show success message
            showLanguageChangeMessage(lang);
        }
    })
    .catch(error => {
        console.error('Error changing language:', error);
            // Fallback: update content without server response
            reloadModalContent(lang);
    });
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
    titleElement.textContent = getLocalizedText('questionnaireTitle', lang);
    
    // Update subtitle
    const subtitleElement = modal.querySelector('.modal-body .text-muted');
    subtitleElement.textContent = getLocalizedText('questionnaireSubtitle', lang);
    
    // Update buttons
    const buttons = modal.querySelectorAll('button[name="section"]');
    const buttonTexts = ['q1', 'q2', 'q3', 'q4'];
    
    buttons.forEach((button, index) => {
        button.textContent = getLocalizedText(buttonTexts[index], lang);
    });
    
    // Update skip button
    const skipButton = modal.querySelector('.btn-link');
    skipButton.textContent = getLocalizedText('skipButton', lang);
}

function getLocalizedText(key, lang) {
    // Localized text mapping
    const texts = {
        'id': {
            'questionnaireTitle': 'Apa yang Anda cari?',
            'questionnaireSubtitle': 'Silakan pilih satu opsi untuk membantu kami melayani Anda dengan lebih baik',
            'q1': 'Saya membutuhkan informasi kontak resmi',
            'q2': 'Saya ingin mengetahui lokasi',
            'q3': 'Saya ingin mengetahui informasi tentang Anda',
            'q4': 'Saya tertarik dengan layanan Anda',
            'skipButton': 'Lewati'
        },
        'en': {
            'questionnaireTitle': 'What are you looking for?',
            'questionnaireSubtitle': 'Please select one option to help us serve you better',
            'q1': 'I need official contact information',
            'q2': 'I want to know the location',
            'q3': 'I want to know information about you',
            'q4': 'I am interested in your services',
            'skipButton': 'Skip'
        }
    };
    
    return texts[lang]?.[key] || texts['en'][key] || key;
}

// Restore language preference when modal opens
document.addEventListener('DOMContentLoaded', function() {
    const savedLang = localStorage.getItem('preferredLanguage');
    if (savedLang && (savedLang === 'id' || savedLang === 'en')) {
        // Update dropdown selection
        const dropdown = document.getElementById('questionnaire-language-switcher');
        if (dropdown) {
            dropdown.value = savedLang;
        }
        
        // Update content if different from current locale
        const currentLang = '{{ app()->getLocale() }}';
        if (savedLang !== currentLang) {
            reloadModalContent(savedLang);
        }
    }
});
</script>