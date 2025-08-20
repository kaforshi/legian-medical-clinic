<nav class="navbar navbar-expand-lg bg-white shadow-sm sticky-top">
    <div class="container">
        <a class="navbar-brand" href="{{ route('home') }}">
            <img src="{{ asset('images/lmc.png') }}" alt="Legian Medical Clinic Logo" style="height: 50px;">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav mx-auto mb-2 mb-lg-0 text-center">
                <li class="nav-item"><a class="nav-link" href="#home">{{ __('messages.navHome') }}</a></li>
                <li class="nav-item"><a class="nav-link" href="#about">{{ __('messages.navAbout') }}</a></li>
                <li class="nav-item"><a class="nav-link" href="#services">{{ __('messages.navServices') }}</a></li>
                <li class="nav-item"><a class="nav-link" href="#doctors">{{ __('messages.navDoctors') }}</a></li>
                <li class="nav-item"><a class="nav-link" href="#contact">{{ __('messages.navContact') }}</a></li>
                <li class="nav-item"><a class="nav-link" href="#faq">{{ __('messages.navFaq') }}</a></li>
            </ul>
            <div class="ms-lg-3">
                <select id="language-switcher" class="form-select" onchange="location = this.value;">
                    <option value="{{ route('lang.swap', 'id') }}" @if(app()->getLocale() == 'id') selected @endif>Indonesia (ID)</option>
                    <option value="{{ route('lang.swap', 'en') }}" @if(app()->getLocale() == 'en') selected @endif>English (EN)</option>
                </select>
            </div>
        </div>
    </div>
</nav>