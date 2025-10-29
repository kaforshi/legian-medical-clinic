<section id="doctors" class="py-5 bg-white">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="fw-bold section-title d-inline-block">{{ __('messages.doctorsTitle') }}</h2>
            <p class="text-muted mt-2">{{ __('messages.doctorsSubtitle') }}</p>
        </div>
        <div id="doctor-list" class="row row-cols-1 row-cols-sm-2 row-cols-lg-4 g-4 text-center">
            @if($doctors->count() > 0)
                @foreach ($doctors as $doctor)
                <div class="col">
                    <div class="doctor-card">
                        <img src="{{ $doctor->photo_url }}" alt="{{ $doctor->name }}" class="rounded-circle shadow-lg mb-3" style="width: 150px; height: 150px; object-fit: cover;">
                        <h5 class="fw-bold mb-0">{{ $doctor->localized_name }}</h5>
                        <p class="text-muted">{{ $doctor->localized_specialization }}</p>
                    </div>
                </div>
                @endforeach
            @else
                <div class="col-12 text-center">
                    <p class="text-muted">Belum ada data dokter yang tersedia.</p>
                </div>
            @endif
        </div>
    </div>
</section>