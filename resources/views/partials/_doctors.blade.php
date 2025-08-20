<section id="doctors" class="py-5 bg-white">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="fw-bold section-title d-inline-block">{{ __('messages.doctorsTitle') }}</h2>
            <p class="text-muted mt-2">{{ __('messages.doctorsSubtitle') }}</p>
        </div>
        <div id="doctor-list" class="row row-cols-1 row-cols-sm-2 row-cols-lg-4 g-4 text-center">
            @foreach (__('messages.doctors') as $doctor)
            <div class="col">
                <div class="doctor-card">
                    <img src="{{ $doctor['img'] }}" alt="{{ $doctor['name'] }}" class="rounded-circle shadow-lg mb-3">
                    <h5 class="fw-bold mb-0">{{ $doctor['name'] }}</h5>
                    <p class="text-muted">{{ $doctor['specialty'] }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>