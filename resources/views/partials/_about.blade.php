<section id="about" class="py-5 bg-white">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="fw-bold section-title d-inline-block">{{ __('messages.aboutTitle') }}</h2>
            <p class="text-muted mt-2">{{ __('messages.aboutSubtitle') }}</p>
        </div>
        <div class="row align-items-center g-5">
            <div class="col-lg-6">
                @if(isset($content['about_us']) && $content['about_us'] && isset($content['about_us']->meta_data['image']))
                    <img src="{{ $content['about_us']->meta_data['image'] }}" alt="Tentang Kami" class="img-fluid rounded shadow-lg">
                @else
                    <img src="https://placehold.co/600x400/e2e8f0/4a5568?text=Interior+Klinik" alt="Tentang Kami" class="img-fluid rounded shadow-lg">
                @endif
            </div>
            <div class="col-lg-6">
                @if(isset($content['about_us']) && $content['about_us'])
                    <h3 class="mb-3">{{ $content['about_us']->title }}</h3>
                    <div class="about-content">
                        {!! $content['about_us']->content !!}
                    </div>
                @else
                    <p class="mb-3">{{ __('messages.aboutContent1') }}</p>
                    <p>{{ __('messages.aboutContent2') }}</p>
                @endif
            </div>
        </div>
    </div>
</section>