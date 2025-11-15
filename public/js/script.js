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
            const href = this.getAttribute('href');
            
            // Skip jika href hanya '#' saja (invalid selector)
            if (!href || href === '#') {
                return;
            }
            
            const target = document.querySelector(href);
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
        return;
    }
    
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

// Scroll Animation using Intersection Observer
function setupScrollAnimations() {
    console.log('Setting up scroll animations...');
    
    // Check if user prefers reduced motion
    const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    
    if (prefersReducedMotion) {
        console.log('User prefers reduced motion, skipping animations');
        // Skip animations if user prefers reduced motion
        document.querySelectorAll('.scroll-animate, section[id], .scroll-animate-children').forEach(el => {
            el.classList.add('animate', 'scroll-animated');
        });
        return;
    }
    
    // Check if Intersection Observer is supported
    if (!('IntersectionObserver' in window)) {
        console.log('IntersectionObserver not supported, showing all content immediately');
        // Fallback: show all content immediately if Intersection Observer is not supported
        document.querySelectorAll('section[id], .scroll-animate, .scroll-animate-children').forEach(el => {
            el.classList.add('animate', 'scroll-animated');
        });
        return;
    }
    
    // Options for Intersection Observer - trigger lebih awal untuk animasi yang lebih smooth
    const observerOptions = {
        root: null, // Use viewport as root
        rootMargin: '0px 0px -100px 0px', // Trigger animation when element is 100px from bottom of viewport (lebih awal)
        threshold: [0, 0.05, 0.1, 0.15, 0.2] // Multiple thresholds untuk animasi yang lebih halus
    };
    
    // Callback function for observer
    const observerCallback = (entries, observer) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                console.log('Element intersecting:', entry.target.id || entry.target.className);
                
                // For sections, add scroll-animated class with slight delay for smooth animation
                if (entry.target.tagName === 'SECTION' && entry.target.id && entry.target.id !== 'home') {
                    console.log('Animating section:', entry.target.id);
                    requestAnimationFrame(() => {
                        entry.target.classList.add('scroll-animated');
                        
                        // Animate children containers within this section
                        const childrenContainers = entry.target.querySelectorAll('.scroll-animate-children');
                        console.log('Found children containers:', childrenContainers.length);
                        childrenContainers.forEach((container, index) => {
                            setTimeout(() => {
                                if (!container.classList.contains('animate')) {
                                    container.classList.add('animate');
                                    console.log('Added animate class to container:', index);
                                }
                            }, index * 50); // Stagger the stagger animations
                        });
                    });
                }
                
                // Add animate class for scroll-animate elements
                if (entry.target.classList.contains('scroll-animate')) {
                    requestAnimationFrame(() => {
                        entry.target.classList.add('animate');
                        console.log('Added animate class to scroll-animate element');
                    });
                }
                
                // If element is a container with stagger animation, animate it
                if (entry.target.classList.contains('scroll-animate-children')) {
                    if (!entry.target.classList.contains('animate')) {
                        requestAnimationFrame(() => {
                            entry.target.classList.add('animate');
                            console.log('Added animate class to scroll-animate-children container');
                        });
                    }
                }
                
                // Stop observing after animation is triggered (for performance)
                // Use a slight delay to ensure animation classes are applied
                setTimeout(() => {
                    observer.unobserve(entry.target);
                }, 100);
            }
        });
    };
    
    // Create Intersection Observer
    const observer = new IntersectionObserver(observerCallback, observerOptions);
    
    // Observe all sections except hero (which is animated immediately if visible)
    const sections = document.querySelectorAll('section[id]');
    console.log('Found sections:', sections.length);
    
    sections.forEach(section => {
        if (section.id !== 'home') {
            console.log('Observing section:', section.id);
            // Observe the section itself
            observer.observe(section);
        } else {
            // Hero section - make it visible immediately
            section.classList.add('scroll-animated');
        }
    });
    
    // Observe elements with scroll-animate class (not inside sections to avoid double observation)
    document.querySelectorAll('.scroll-animate').forEach(element => {
        if (!element.closest('section[id]')) {
            observer.observe(element);
        }
    });
    
    // Observe containers with stagger animation separately
    // Observe both standalone containers and those inside sections (section observation will handle children)
    document.querySelectorAll('.scroll-animate-children').forEach(container => {
        // Observe all containers, the callback will handle whether to animate based on parent section state
        observer.observe(container);
    });
    
    // Animate hero section immediately if visible on load (don't observe it)
    const heroSection = document.getElementById('home');
    if (heroSection) {
        const heroRect = heroSection.getBoundingClientRect();
        if (heroRect.top < window.innerHeight && heroRect.bottom > 0) {
            heroSection.classList.add('scroll-animated');
        }
    }
    
    // Force initial check for elements already in viewport (with delay to ensure DOM is ready)
    const initialCheck = () => {
        console.log('Running initial check...');
        document.querySelectorAll('section[id]').forEach(section => {
            if (section.id !== 'home') {
                const rect = section.getBoundingClientRect();
                // Check if section is already visible or near viewport (more lenient check)
                const isPartiallyVisible = rect.top < window.innerHeight + 200 && rect.bottom > -100;
                if (isPartiallyVisible && !section.classList.contains('scroll-animated')) {
                    console.log('Section already visible, animating:', section.id);
                    // Add class with requestAnimationFrame for smooth animation
                    requestAnimationFrame(() => {
                        section.classList.add('scroll-animated');
                        // Also animate children with slight delay
                        const childrenContainers = section.querySelectorAll('.scroll-animate-children');
                        childrenContainers.forEach((container, index) => {
                            setTimeout(() => {
                                if (!container.classList.contains('animate')) {
                                    container.classList.add('animate');
                                }
                            }, 100 + (index * 50));
                        });
                    });
                }
            } else {
                // Hero section - ensure it's visible
                section.classList.add('scroll-animated');
            }
        });
        
        // Also check standalone scroll-animate and scroll-animate-children elements
        document.querySelectorAll('.scroll-animate, .scroll-animate-children').forEach(element => {
            const rect = element.getBoundingClientRect();
            const isPartiallyVisible = rect.top < window.innerHeight + 200 && rect.bottom > -100;
            if (isPartiallyVisible) {
                if (element.classList.contains('scroll-animate') && !element.classList.contains('animate')) {
                    requestAnimationFrame(() => {
                        element.classList.add('animate');
                    });
                } else if (element.classList.contains('scroll-animate-children') && !element.classList.contains('animate')) {
                    requestAnimationFrame(() => {
                        element.classList.add('animate');
                    });
                }
            }
        });
    };
    
    // Run initial check after DOM is ready
    setTimeout(initialCheck, 200);
    
    // Also run on window load to catch any sections that become visible
    window.addEventListener('load', () => {
        setTimeout(initialCheck, 150);
    });
    
    // Re-check on resize to catch any layout changes
    let resizeTimeout;
    window.addEventListener('resize', () => {
        clearTimeout(resizeTimeout);
        resizeTimeout = setTimeout(initialCheck, 250);
    });
}

// Lazy load images with fade-in effect
function setupLazyLoadImages() {
    if ('IntersectionObserver' in window) {
        const imageObserver = new IntersectionObserver((entries, observer) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const img = entry.target;
                    if (img.dataset.src) {
                        img.src = img.dataset.src;
                        img.removeAttribute('data-src');
                    }
                    img.setAttribute('data-loaded', 'true');
                    observer.unobserve(img);
                }
            });
        }, {
            rootMargin: '50px'
        });
        
        document.querySelectorAll('img[data-src]').forEach(img => {
            imageObserver.observe(img);
        });
    }
}

// Event listener utama
document.addEventListener('DOMContentLoaded', function() {
    // Setup smooth scroll
    setupSmoothScroll();
    
    // Setup FAQ search and filter
    setupFaqSearchAndFilter();
    
    // Setup fixed navbar
    setupFixedNavbar();
    
    // Setup scroll animations
    setupScrollAnimations();
    
    // Setup lazy loading for images
    setupLazyLoadImages();
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

// Script loaded