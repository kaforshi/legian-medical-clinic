<section id="services" class="py-5 bg-light">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="fw-bold section-title d-inline-block">{{ __('messages.servicesTitle') }}</h2>
            <p class="text-muted mt-2">{{ __('messages.servicesSubtitle') }}</p>
        </div>
        <div id="service-list" class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
            @if($services->count() > 0)
                @foreach ($services as $service)
                <div class="col">
                    <div class="card h-100 text-center border-0 shadow-sm service-card p-3">
                        <div class="card-body">
                            <div class="icon mb-3">
                                @if($service->icon && !Str::startsWith($service->icon, 'fas '))
                                    <img src="{{ $service->icon_url }}" alt="{{ $service->name }}" style="width: 50px; height: 50px; object-fit: contain;">
                                @else
                                    <i class="fas {{ $service->icon ?? 'fa-stethoscope' }}"></i>
                                @endif
                            </div>
                            <h5 class="card-title fw-bold">{{ $service->name }}</h5>
                            <p class="card-text text-muted">{{ $service->description }}</p>
                            @if($service->price)
                                <p class="text-primary fw-bold">Rp {{ number_format($service->price, 0, ',', '.') }}</p>
                            @endif
                        </div>
                    </div>
                </div>
                @endforeach
            @else
                <div class="col-12 text-center">
                    <p class="text-muted">Belum ada layanan yang tersedia.</p>
                </div>
            @endif
        </div>
    </div>
</section>