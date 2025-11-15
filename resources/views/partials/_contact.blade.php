<section id="contact" class="py-5 bg-light">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="fw-bold section-title d-inline-block">{{ __('messages.contactTitle') }}</h2>
            <p class="text-muted mt-2">{{ __('messages.contactSubtitle') }}</p>
        </div>
        <div class="row g-4 scroll-animate-children">
            <div class="col-lg-6">
                <div class="bg-white p-4 rounded shadow-sm h-100">
                    @if(isset($content['contact']) && $content['contact'])
                        <h3 class="fw-bold mb-4">{{ $content['contact']->title }}</h3>
                        <div class="contact-content">
                            {!! $content['contact']->content !!}
                        </div>
                    @else
                        <h3 class="fw-bold mb-4">{{ __('messages.contactInfoTitle') }}</h3>
                        <ul class="list-unstyled">
                            <li class="d-flex mb-3"><i class="fas fa-map-marker-alt text-primary fa-fw me-3 mt-1"></i><span>{{ __('messages.contactAddress') }}</span></li>
                            <li class="d-flex mb-3"><i class="fas fa-phone-alt text-primary fa-fw me-3 mt-1"></i><a href="tel:+62361123456" class="text-decoration-none text-dark">+62 361 123456</a></li>
                            <li class="d-flex mb-3"><i class="fas fa-envelope text-primary fa-fw me-3 mt-1"></i><a href="mailto:info@legianclinic.com" class="text-decoration-none text-dark">info@legianclinic.com</a></li>
                            <li class="d-flex"><i class="fas fa-clock text-primary fa-fw me-3 mt-1"></i><span>{!! __('messages.contactHours') !!}</span></li>
                        </ul>
                    @endif
                </div>
            </div>
            <div class="col-lg-6">
                <div class="ratio ratio-4x3 rounded shadow-sm overflow-hidden">
                    @if(isset($content['contact']) && $content['contact'] && isset($content['contact']->meta_data['map_url']))
                        <iframe src="{{ $content['contact']->meta_data['map_url'] }}" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                    @else
                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3944.20013312959!2d115.1685323153949!3d-8.672688693766952!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2dd2475c401e69bb%3A0x8a45218765f1e83e!2sJl.%20Raya%20Legian%2C%20Kuta%2C%20Kabupaten%20Badung%2C%20Bali!5e0!3m2!1sid!2sid!4v1663152912423!5m2!1sid!2sid" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>