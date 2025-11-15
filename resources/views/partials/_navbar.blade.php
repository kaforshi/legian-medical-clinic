<nav class="navbar navbar-expand-lg bg-white shadow-sm fixed-top">
    <div class="container">
        {{-- Brand/Logo --}}
        <a class="navbar-brand" href="{{ route('home') }}">
            <img src="{{ asset('images/lmc.png') }}" alt="Legian Medical Clinic Logo" style="height: 50px;">
        </a>
        
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        
        <div class="collapse navbar-collapse" id="navbarNav">
            <div class="w-100 position-relative d-flex align-items-center">
                {{-- Menu utama di tengah (center absolut) --}}
                <ul class="navbar-nav navbar-nav-center">
                    <li class="nav-item"><a class="nav-link" href="#home">{{ __('messages.navHome') }}</a></li>
                    <li class="nav-item"><a class="nav-link" href="#about">{{ __('messages.navAbout') }}</a></li>
                    <li class="nav-item"><a class="nav-link" href="#services">{{ __('messages.navServices') }}</a></li>
                    <li class="nav-item"><a class="nav-link" href="#doctors">{{ __('messages.navDoctors') }}</a></li>
                    <li class="nav-item"><a class="nav-link" href="#contact">{{ __('messages.navContact') }}</a></li>
                    <li class="nav-item"><a class="nav-link" href="#faq">{{ __('messages.navFaq') }}</a></li>
                </ul>
                
                {{-- Language switcher dan tombol Buat Janji di pojok kanan --}}
                <div class="d-flex align-items-center gap-3 navbar-actions" style="position: absolute; right: 0; top: 50%; transform: translateY(-50%); z-index: 10;">
                    {{-- Language Switcher --}}
                    <div class="language-switcher-wrapper position-relative">
                        <button class="btn btn-language-switcher" type="button" id="language-switcher-btn" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-globe"></i>
                            <span class="lang-code">{{ strtoupper(app()->getLocale()) }}</span>
                            <i class="fas fa-chevron-down ms-1"></i>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end language-dropdown" aria-labelledby="language-switcher-btn">
                            <li>
                                <a class="dropdown-item" href="#" onclick="changeWebsiteLanguage('id'); return false;">
                                    <span>Bahasa (ID)</span>
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="#" onclick="changeWebsiteLanguage('en'); return false;">
                                    <span>English (EN)</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                    
                    {{-- Tombol Buat Janji --}}
                    <a href="#contact" class="btn btn-primary btn-book-appointment" id="book-appointment-btn" data-default-text="{{ __('messages.bookAppointment') }}">
                        {{ __('messages.bookAppointment') }}
                    </a>
                </div>
            </div>
        </div>
    </div>
</nav>