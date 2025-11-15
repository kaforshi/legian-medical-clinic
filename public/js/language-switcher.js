/**
 * Language Switcher untuk Website
 * Mengubah bahasa tanpa reload halaman
 */

// Translation data (akan di-load dari server)
let translationData = {};

/**
 * Change website language without reload
 */
async function changeWebsiteLanguage(locale) {
    if (!locale || !['id', 'en'].includes(locale)) {
        console.error('Invalid locale:', locale);
        return;
    }

    // Show loading indicator
    const switcher = document.getElementById('language-switcher');
    if (switcher) {
        switcher.disabled = true;
    }

    try {
        // 1. Update session via AJAX
        const response = await axios.get(`/lang/${locale}`, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        });

        if (response.data.success) {
            // 2. Store language preference
            localStorage.setItem('preferredLanguage', locale);
            
            // Update document lang attribute
            document.documentElement.lang = locale;

            // Update language switcher display
            const langCodeSpan = document.querySelector('.btn-language-switcher .lang-code');
            if (langCodeSpan) {
                langCodeSpan.textContent = locale.toUpperCase();
            }

            // 3. Update all content dynamically
            await updatePageContent(locale);

            // 4. Show success message
            if (typeof showToast === 'function') {
                const langName = locale === 'id' ? 'Bahasa Indonesia' : 'English';
                showToast(`${langName} telah dipilih`, 'success');
            }
        } else {
            throw new Error(response.data.message || 'Failed to change language');
        }
    } catch (error) {
        console.error('Error changing language:', error);
        if (typeof showToast === 'function') {
            showToast('Terjadi kesalahan saat mengganti bahasa', 'error');
        }
        // Revert dropdown selection
        if (switcher) {
            const currentLang = '{{ app()->getLocale() }}';
            switcher.value = currentLang;
        }
    } finally {
        if (switcher) {
            switcher.disabled = false;
        }
    }
}

/**
 * Update page content based on locale
 */
async function updatePageContent(locale) {
    try {
        // Fetch updated content from server
        const response = await axios.get(`/api/content/${locale}`, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        });

        if (response.data.success) {
            const data = response.data.data;

            // Messages received - no logging needed in production

            // Update navbar menu items
            updateNavbar(data.messages);

            // Update hero section
            updateHero(data.messages, data.heroSlides);

            // Update sections titles
            updateSectionTitles(data.messages);

            // Update doctors
            updateDoctors(data.doctors);

            // Update services
            updateServices(data.services);

            // Update FAQs
            updateFAQs(data.faqs, data.messages);

            // Update about section
            updateAbout(data.content);

            // Update contact section
            updateContact(data.content, data.messages);

            // Update questionnaire modal
            updateQuestionnaireModal(data.messages);
        }
    } catch (error) {
        console.error('Error updating page content:', error);
        // Fallback: reload page if API fails
        window.location.reload();
    }
}

/**
 * Update navbar menu items
 */
function updateNavbar(messages) {
    const navLinks = {
        'navHome': document.querySelector('a[href="#home"]'),
        'navAbout': document.querySelector('a[href="#about"]'),
        'navServices': document.querySelector('a[href="#services"]'),
        'navDoctors': document.querySelector('a[href="#doctors"]'),
        'navContact': document.querySelector('a[href="#contact"]'),
        'navFaq': document.querySelector('a[href="#faq"]')
    };

    Object.keys(navLinks).forEach(key => {
        if (navLinks[key] && messages[key]) {
            navLinks[key].textContent = messages[key];
        }
    });

    // Update book appointment button
    const bookAppointmentBtn = document.getElementById('book-appointment-btn');
    if (bookAppointmentBtn) {
        if (messages && messages.bookAppointment) {
            // Gunakan innerHTML untuk memastikan teks ter-render dengan benar
            bookAppointmentBtn.innerHTML = messages.bookAppointment;
        } else {
            // Fallback ke default text dari data attribute atau current text
            const defaultText = bookAppointmentBtn.getAttribute('data-default-text');
            const currentText = bookAppointmentBtn.textContent.trim();
            
            // Gunakan default text jika ada dan bukan literal "messages.bookAppointment"
            if (defaultText && defaultText !== 'messages.bookAppointment') {
                bookAppointmentBtn.innerHTML = defaultText;
            } else if (currentText && currentText !== 'messages.bookAppointment') {
                // Gunakan current text sebagai fallback jika tidak ada default text
                // Do nothing, keep current text
            } else {
                // Hard-coded fallback berdasarkan locale
                const locale = document.documentElement.lang || 'id';
                const fallbackText = locale === 'id' ? 'Buat Janji Temu' : 'Book Appointment';
                bookAppointmentBtn.innerHTML = fallbackText;
            }
        }
    }
}

/**
 * Update hero section
 */
function updateHero(messages, heroSlides) {
    // Check if hero carousel exists (dynamic hero slides)
    const heroCarousel = document.getElementById('heroCarousel');
    if (heroCarousel && heroSlides && heroSlides.length > 0) {
        // Update carousel slides
        const carouselItems = heroCarousel.querySelectorAll('.carousel-item');
        carouselItems.forEach((item, index) => {
            if (heroSlides[index]) {
                const slide = heroSlides[index];
                const titleEl = item.querySelector('h1');
                const subtitleEl = item.querySelector('.lead');
                const buttonEl = item.querySelector('.btn');
                
                if (titleEl) {
                    titleEl.textContent = slide.localized_title || slide.title_id || '';
                }
                if (subtitleEl) {
                    subtitleEl.textContent = slide.localized_subtitle || slide.subtitle_id || '';
                }
                if (buttonEl) {
                    buttonEl.textContent = slide.localized_button_text || slide.button_text_id || '';
                    if (slide.button_link) {
                        buttonEl.setAttribute('href', slide.button_link);
                    }
                }
            }
        });
    } else {
        // Fallback: Update static hero section (old format)
        const heroTitle = document.querySelector('#home .hero-section h1');
        const heroSubtitle = document.querySelector('#home .hero-section .lead');
        const heroButton = document.querySelector('#home .hero-section .btn');

        if (heroTitle && messages && messages.heroTitle) {
            heroTitle.textContent = messages.heroTitle;
        }
        if (heroSubtitle && messages && messages.heroSubtitle) {
            heroSubtitle.textContent = messages.heroSubtitle;
        }
        if (heroButton && messages && messages.heroButton) {
            heroButton.textContent = messages.heroButton;
        }
    }
}

/**
 * Update section titles
 */
function updateSectionTitles(messages) {
    // About section
    const aboutTitle = document.querySelector('#about h2');
    const aboutSubtitle = document.querySelector('#about .text-muted.mt-2');
    if (aboutTitle && messages.aboutTitle) aboutTitle.textContent = messages.aboutTitle;
    if (aboutSubtitle && messages.aboutSubtitle) aboutSubtitle.textContent = messages.aboutSubtitle;

    // Services section
    const servicesTitle = document.querySelector('#services h2');
    const servicesSubtitle = document.querySelector('#services .text-muted.mt-2');
    if (servicesTitle && messages.servicesTitle) servicesTitle.textContent = messages.servicesTitle;
    if (servicesSubtitle && messages.servicesSubtitle) servicesSubtitle.textContent = messages.servicesSubtitle;

    // Doctors section
    const doctorsTitle = document.querySelector('#doctors h2');
    const doctorsSubtitle = document.querySelector('#doctors .text-muted.mt-2');
    if (doctorsTitle && messages.doctorsTitle) doctorsTitle.textContent = messages.doctorsTitle;
    if (doctorsSubtitle && messages.doctorsSubtitle) doctorsSubtitle.textContent = messages.doctorsSubtitle;

    // Contact section
    const contactTitle = document.querySelector('#contact h2');
    const contactSubtitle = document.querySelector('#contact .text-muted.mt-2');
    if (contactTitle && messages.contactTitle) contactTitle.textContent = messages.contactTitle;
    if (contactSubtitle && messages.contactSubtitle) contactSubtitle.textContent = messages.contactSubtitle;

    // FAQ section
    const faqTitle = document.querySelector('#faq h2');
    const faqSubtitle = document.querySelector('#faq .text-muted.mt-2');
    if (faqTitle && messages.faqTitle) faqTitle.textContent = messages.faqTitle;
    if (faqSubtitle && messages.faqSubtitle) faqSubtitle.textContent = messages.faqSubtitle;
}

/**
 * Update doctors content
 */
function updateDoctors(doctors) {
    const doctorList = document.getElementById('doctor-list');
    if (!doctorList || !doctors) return;

    const doctorCards = doctorList.querySelectorAll('.doctor-card');
    doctorCards.forEach((card, index) => {
        if (doctors[index]) {
            const nameElement = card.querySelector('h5');
            const specElement = card.querySelector('p.text-muted');
            
            if (nameElement) {
                nameElement.textContent = doctors[index].localized_name || doctors[index].name_id || '';
            }
            if (specElement) {
                specElement.textContent = doctors[index].localized_specialization || doctors[index].specialization_id || '';
            }
        }
    });
}

/**
 * Update services content
 */
function updateServices(services) {
    const serviceList = document.getElementById('service-list');
    if (!serviceList || !services) return;

    const serviceCards = serviceList.querySelectorAll('.service-card');
    serviceCards.forEach((card, index) => {
        if (services[index]) {
            const nameElement = card.querySelector('h5');
            const descElement = card.querySelector('.card-text');
            
            if (nameElement) {
                nameElement.textContent = services[index].localized_name || services[index].name_id || '';
            }
            if (descElement) {
                descElement.innerHTML = services[index].localized_description || services[index].description_id || '';
            }
        }
    });
}

/**
 * Update FAQs content
 */
function updateFAQs(faqs, messages) {
    const faqContainer = document.querySelector('#faq .accordion');
    if (!faqContainer || !faqs || faqs.length === 0) return;

    const faqItems = faqContainer.querySelectorAll('.accordion-item');
    faqItems.forEach((item, index) => {
        if (faqs[index]) {
            const questionElement = item.querySelector('.accordion-button');
            const answerElement = item.querySelector('.accordion-body');
            
            if (questionElement) {
                // Preserve badge if exists
                const badge = questionElement.querySelector('.badge');
                const badgeHTML = badge ? badge.outerHTML : '';
                questionElement.innerHTML = (faqs[index].localized_question || faqs[index].question_id || '') + (badgeHTML ? ' ' + badgeHTML : '');
            }
            if (answerElement) {
                answerElement.innerHTML = faqs[index].localized_answer || faqs[index].answer_id || '';
            }
        }
    });
    
    // Update search placeholder
    const faqSearch = document.getElementById('faq-search');
    if (faqSearch) {
        faqSearch.placeholder = messages?.searchFaq || 'Cari FAQ...';
    }
    
    // Update category filter
    const faqCategoryFilter = document.getElementById('faq-category-filter');
    if (faqCategoryFilter && faqCategoryFilter.options.length > 0) {
        faqCategoryFilter.options[0].text = messages?.allCategories || 'Semua Kategori';
    }
}

/**
 * Update about section content
 */
function updateAbout(content) {
    if (!content) return;

    const aboutTitle = document.querySelector('#about h3');
    const aboutContent = document.querySelector('#about .about-content');
    const aboutImage = document.querySelector('#about img');
    
    if (content.about_us) {
        if (aboutTitle && content.about_us.title) {
            aboutTitle.textContent = content.about_us.title;
        }
        if (aboutContent && content.about_us.content) {
            aboutContent.innerHTML = content.about_us.content;
        }
        // Update image if exists in meta_data
        if (aboutImage && content.about_us.meta_data && content.about_us.meta_data.image) {
            aboutImage.src = content.about_us.meta_data.image;
        }
    }
}

/**
 * Update contact section content
 */
function updateContact(content, messages) {
    if (!content) {
        return;
    }

    const contactTitle = document.querySelector('#contact h3');
    const contactContent = document.querySelector('#contact .contact-content');
    const contactMap = document.querySelector('#contact iframe');
    
    if (content.contact) {
        // Update title and content
        if (contactTitle && content.contact.title) {
            contactTitle.textContent = content.contact.title;
        }
        if (contactContent && content.contact.content) {
            contactContent.innerHTML = content.contact.content;
        }
        // Update map if exists in meta_data
        if (contactMap && content.contact.meta_data && content.contact.meta_data.map_url) {
            contactMap.src = content.contact.meta_data.map_url;
        }
    } else {
        // Update default contact info if no content from database
        const contactInfoTitle = document.querySelector('#contact h3');
        const contactAddress = document.querySelector('#contact .fa-map-marker-alt')?.parentElement?.querySelector('span');
        const contactHours = document.querySelector('#contact .fa-clock')?.parentElement?.querySelector('span');
        
        if (contactInfoTitle && messages.contactInfoTitle) {
            contactInfoTitle.textContent = messages.contactInfoTitle;
        }
        if (contactAddress && messages.contactAddress) {
            contactAddress.textContent = messages.contactAddress;
        }
        if (contactHours && messages.contactHours) {
            contactHours.innerHTML = messages.contactHours;
        }
    }
}

/**
 * Update questionnaire modal content
 */
function updateQuestionnaireModal(messages) {
    const modalTitle = document.getElementById('questionnaireModalLabel');
    const modalSubtitle = document.querySelector('#questionnaireModal .questionnaire-subtitle');
    const skipButton = document.querySelector('#questionnaireModal .questionnaire-skip-link');
    
    if (modalTitle && messages.questionnaireTitle) {
        modalTitle.textContent = messages.questionnaireTitle;
    }
    if (modalSubtitle && messages.questionnaireSubtitle) {
        modalSubtitle.textContent = messages.questionnaireSubtitle;
    }
    if (skipButton && messages.skipButton) {
        skipButton.textContent = messages.skipButton;
    }

    // Update questionnaire buttons text (keep icons)
    const buttons = document.querySelectorAll('.questionnaire-btn');
    const buttonTexts = ['q1', 'q2', 'q3', 'q4'];
    
    buttons.forEach((button, index) => {
        if (messages[buttonTexts[index]]) {
            const textSpan = button.querySelector('.questionnaire-btn-text');
            if (textSpan) {
                textSpan.textContent = messages[buttonTexts[index]];
            }
        }
    });
    
    // Update language switcher text in modal
    const modalLangText = document.querySelector('.questionnaire-lang-text');
    if (modalLangText) {
        const currentLang = document.documentElement.lang || 'id';
        modalLangText.textContent = currentLang === 'id' ? 'Indonesia (ID)' : 'English (EN)';
    }
}

// Export function for global use
window.changeWebsiteLanguage = changeWebsiteLanguage;

