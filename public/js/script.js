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
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                const navbar = document.querySelector('nav.navbar');
                const navbarHeight = navbar ? navbar.offsetHeight : 0;
                const targetPosition = target.offsetTop - navbarHeight - 20;
                
                window.scrollTo({
                    top: targetPosition,
                    behavior: 'smooth'
                });
            }
        });
    });
}

// Fungsi untuk setup fixed navbar scroll effect
function setupFixedNavbar() {
    const navbar = document.querySelector('.navbar');
    
    if (!navbar) {
        console.log('Navbar not found, skipping navbar setup');
        return;
    }

    console.log('Setting up fixed navbar with scroll effects');
    
    window.addEventListener('scroll', function() {
        const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
        
        // Add/remove scrolled class for visual effects
        if (scrollTop > 50) {
            navbar.classList.add('navbar-scrolled');
        } else {
            navbar.classList.remove('navbar-scrolled');
        }
    });
}

// Event listener utama
document.addEventListener('DOMContentLoaded', function() {
    console.log('DOM loaded');
    
    // Setup smooth scroll
    setupSmoothScroll();
    
    // Setup FAQ search and filter
    setupFaqSearchAndFilter();
    
    // Setup fixed navbar
    setupFixedNavbar();
});

// FAQ Search and Filter functionality
function setupFaqSearchAndFilter() {
    const searchInput = document.getElementById('faq-search');
    const searchBtn = document.getElementById('faq-search-btn');
    const categoryFilter = document.getElementById('faq-category-filter');
    const faqItems = document.querySelectorAll('#faq-accordion .accordion-item');
    
    if (!searchInput || !categoryFilter) return;
    
    // Search functionality
    function performSearch() {
        const searchTerm = searchInput.value.toLowerCase().trim();
        const selectedCategory = categoryFilter.value;
        
        faqItems.forEach(item => {
            const question = item.querySelector('.accordion-button').textContent.toLowerCase();
            const answer = item.querySelector('.accordion-body').textContent.toLowerCase();
            const category = item.dataset.category || '';
            
            const matchesSearch = !searchTerm || question.includes(searchTerm) || answer.includes(searchTerm);
            const matchesCategory = !selectedCategory || category === selectedCategory;
            
            if (matchesSearch && matchesCategory) {
                item.style.display = 'block';
                item.classList.remove('d-none');
            } else {
                item.style.display = 'none';
                item.classList.add('d-none');
            }
        });
        
        // Show/hide no results message
        const visibleItems = Array.from(faqItems).filter(item => item.style.display !== 'none');
        const noResultsMsg = document.getElementById('faq-no-results');
        
        if (visibleItems.length === 0) {
            if (!noResultsMsg) {
                const msg = document.createElement('div');
                msg.id = 'faq-no-results';
                msg.className = 'text-center text-muted py-4';
                msg.innerHTML = '<i class="fas fa-search fa-2x mb-3"></i><p>{{ __("messages.noFaqResults") }}</p>';
                document.getElementById('faq-accordion').appendChild(msg);
            }
        } else if (noResultsMsg) {
            noResultsMsg.remove();
        }
    }
    
    // Event listeners
    if (searchInput) {
        searchInput.addEventListener('input', performSearch);
        searchInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                performSearch();
            }
        });
    }
    
    if (searchBtn) {
        searchBtn.addEventListener('click', performSearch);
    }
    
    if (categoryFilter) {
        categoryFilter.addEventListener('change', performSearch);
    }
}

console.log('Script loaded successfully');