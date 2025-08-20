// Fungsi untuk memprioritaskan section dan scroll ke section tersebut
function prioritizeAndScrollToSection(sectionId) {
    // Simpan status bahwa kuesioner sudah dijawab
    sessionStorage.setItem('questionnaireAnswered', 'true');
    
    // Tutup modal kuesioner
    const questionnaireModal = bootstrap.Modal.getInstance(document.getElementById('questionnaireModal'));
    if (questionnaireModal) {
        questionnaireModal.hide();
    }
    
    // Alihkan halaman ke URL baru dengan section yang dipilih
    window.location.href = `/${sectionId}`;
}

// Fungsi untuk smooth scroll pada link navigasi
function setupSmoothScroll() {
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const targetId = this.getAttribute('href');
            const targetElement = document.querySelector(targetId);

            if (targetElement) {
                const header = document.querySelector('nav.navbar');
                const headerHeight = header ? header.offsetHeight : 0;
                const targetPosition = targetElement.getBoundingClientRect().top + window.pageYOffset - headerHeight;

                window.scrollTo({
                    top: targetPosition,
                    behavior: 'smooth'
                });
            }
        });
    });
}

// Fungsi utama untuk menampilkan modal kuesioner
function showQuestionnaire() {
    console.log('Attempting to show questionnaire...');
    
    const modal = document.getElementById('questionnaireModal');
    if (!modal) {
        console.error('Modal element not found!');
        return;
    }
    
    console.log('Modal element found, showing...');
    
    // Coba dengan Bootstrap
    if (typeof bootstrap !== 'undefined') {
        try {
            const bootstrapModal = new bootstrap.Modal(modal);
            bootstrapModal.show();
            console.log('Modal shown with Bootstrap');
        } catch (error) {
            console.error('Bootstrap error:', error);
            // Fallback CSS
            modal.style.display = 'block';
            modal.classList.add('show');
            document.body.classList.add('modal-open');
        }
    } else {
        console.log('Bootstrap not available, using CSS');
        modal.style.display = 'block';
        modal.classList.add('show');
        document.body.classList.add('modal-open');
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

// Event listener utama
document.addEventListener('DOMContentLoaded', function() {
    console.log('DOM loaded, checking questionnaire...');
    
    // Cek status kuesioner
    const answered = sessionStorage.getItem('questionnaireAnswered');
    console.log('Questionnaire answered:', answered);
    
    if (!answered) {
        console.log('Will show questionnaire in 2 seconds...');
        setTimeout(showQuestionnaire, 2000);
    }
    
    // Setup smooth scroll
    setupSmoothScroll();
    
    // Setup event handler untuk tombol skip
    setupSkipButtonHandler();
});

// Fallback event listener
window.addEventListener('load', function() {
    console.log('Window loaded, checking questionnaire...');
    
    const answered = sessionStorage.getItem('questionnaireAnswered');
    if (!answered) {
        console.log('Will show questionnaire in 1 second...');
        setTimeout(showQuestionnaire, 1000);
    }
    
    // Setup event handler untuk tombol skip
    setupSkipButtonHandler();
});

// Setup skip button dengan event handler yang proper
function setupSkipButtonHandler() {
    const skipButton = document.querySelector('#questionnaireModal button[data-bs-dismiss="modal"]');
    if (skipButton) {
        // Hapus event listener lama jika ada
        skipButton.removeEventListener('click', handleSkipClick);
        // Tambahkan event listener baru
        skipButton.addEventListener('click', handleSkipClick);
        console.log('Skip button handler setup complete');
    }
}

// Handler untuk tombol skip
function handleSkipClick() {
    console.log('Skip button clicked');
    
    // Simpan status bahwa kuesioner sudah dijawab
    sessionStorage.setItem('questionnaireAnswered', 'true');
    
    // Hapus backdrop dan class modal-open jika ada
    cleanupModalBackdrop();
    
    console.log('Questionnaire skipped and cleaned up');
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

console.log('Questionnaire script loaded successfully');