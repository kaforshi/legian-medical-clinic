<section id="home" class="hero-section">
    <div class="hero-bg text-white d-flex align-items-center" style="background-image: url('{{ asset('images/hero.png') }}');">
        <div class="hero-overlay d-flex align-items-center">
            <div class="container text-center">
                <h1 class="display-3 fw-bold mb-3">{{ __('messages.heroTitle') }}</h1>
                <p class="lead mb-4 mx-auto" style="max-width: 600px;">{{ __('messages.heroSubtitle') }}</p>
                <a href="#contact" class="btn btn-primary btn-lg rounded-pill px-4">{{ __('messages.heroButton') }}</a>
            </div>
        </div>
    </div>
</section>