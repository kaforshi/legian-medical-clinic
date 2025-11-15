@if(isset($heroSlides) && $heroSlides->count() > 0)
<section id="home" class="hero-section">
    <div id="heroCarousel" class="carousel slide carousel-fade" data-bs-ride="carousel" data-bs-interval="5000">
        <div class="carousel-indicators">
            @foreach($heroSlides as $index => $slide)
                <button type="button" 
                        data-bs-target="#heroCarousel" 
                        data-bs-slide-to="{{ $index }}" 
                        class="{{ $index === 0 ? 'active' : '' }}"
                        aria-current="{{ $index === 0 ? 'true' : 'false' }}"
                        aria-label="Slide {{ $index + 1 }}"></button>
            @endforeach
        </div>
        
        <div class="carousel-inner">
            @foreach($heroSlides as $index => $slide)
                <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                    <div class="hero-bg text-white d-flex align-items-center" style="background-image: url('{{ $slide->image_url }}');">
                        <div class="hero-overlay d-flex align-items-center">
                            <div class="container text-center">
                                <h1 class="display-3 fw-bold mb-3">{{ $slide->localized_title }}</h1>
                                <p class="lead mb-4 mx-auto" style="max-width: 600px;">{{ $slide->localized_subtitle }}</p>
                                <a href="{{ $slide->button_link }}" class="btn btn-primary btn-lg rounded-pill px-4">{{ $slide->localized_button_text }}</a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        
        <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>
</section>
@else
{{-- Fallback jika tidak ada hero slides --}}
<section id="home" class="hero-section">
    <div class="hero-bg text-white d-flex align-items-center" style="background-image: url('{{ asset('images/hero.jpg') }}');">
        <div class="hero-overlay d-flex align-items-center">
            <div class="container text-center">
                <h1 class="display-3 fw-bold mb-3">{{ __('messages.heroTitle') }}</h1>
                <p class="lead mb-4 mx-auto" style="max-width: 600px;">{{ __('messages.heroSubtitle') }}</p>
                <a href="#contact" class="btn btn-primary btn-lg rounded-pill px-4">{{ __('messages.heroButton') }}</a>
            </div>
        </div>
    </div>
</section>
@endif
