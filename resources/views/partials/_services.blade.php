<section id="services" class="py-5 bg-light">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="fw-bold section-title d-inline-block">{{ __('messages.servicesTitle') }}</h2>
            <p class="text-muted mt-2">{{ __('messages.servicesSubtitle') }}</p>
        </div>
        <div id="service-list" class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
            @foreach (__('messages.services') as $service)
            <div class="col">
                <div class="card h-100 text-center border-0 shadow-sm service-card p-3">
                    <div class="card-body">
                        <div class="icon mb-3"><i class="fas {{ $service['icon'] }}"></i></div>
                        <h5 class="card-title fw-bold">{{ $service['title'] }}</h5>
                        <p class="card-text text-muted">{{ $service['description'] }}</p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>