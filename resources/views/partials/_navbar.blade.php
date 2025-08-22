<nav class="navbar navbar-expand-lg bg-white shadow-sm fixed-top">
    <div class="container">
        <a class="navbar-brand" href="{{ route('home') }}">
            <img src="{{ asset('images/lmc.png') }}" alt="Legian Medical Clinic Logo" style="height: 50px;">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <div class="w-100 d-flex justify-content-between align-items-center">
                {{-- Spacer kiri --}}
                <div class="navbar-spacer d-none d-lg-block" style="width: 200px;"></div>
                
                {{-- Menu utama di tengah --}}
                <ul class="navbar-nav text-center">
                    <li class="nav-item"><a class="nav-link" href="#home">{{ __('messages.navHome') }}</a></li>
                    <li class="nav-item"><a class="nav-link" href="#about">{{ __('messages.navAbout') }}</a></li>
                    <li class="nav-item"><a class="nav-link" href="#services">{{ __('messages.navServices') }}</a></li>
                    <li class="nav-item"><a class="nav-link" href="#doctors">{{ __('messages.navDoctors') }}</a></li>
                    <li class="nav-item"><a class="nav-link" href="#contact">{{ __('messages.navContact') }}</a></li>
                    <li class="nav-item"><a class="nav-link" href="#faq">{{ __('messages.navFaq') }}</a></li>
                </ul>
                
                {{-- Language switcher dan admin button di kanan --}}
                <div class="d-flex align-items-center gap-2" style="width: 200px; justify-content: flex-end;">
                    <select id="language-switcher" class="form-select form-select-sm" onchange="location = this.value;">
                        <option value="{{ route('lang.swap', 'id') }}" @if(app()->getLocale() == 'id') selected @endif>Indonesia (ID)</option>
                        <option value="{{ route('lang.swap', 'en') }}" @if(app()->getLocale() == 'en') selected @endif>English (EN)</option>
                    </select>
                    <a href="{{ route('admin.login') }}" class="btn btn-outline-primary btn-sm" title="Admin Panel">
                        <i class="fas fa-cog"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</nav>