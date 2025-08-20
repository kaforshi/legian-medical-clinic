<div class="modal fade" id="questionnaireModal" tabindex="-1" aria-labelledby="questionnaireModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content shadow-lg border-0">
            <div class="modal-body p-4 p-md-5 text-center">
                <h2 class="modal-title fw-bold mb-3" id="questionnaireModalLabel">{{ __('messages.questionnaireTitle') }}</h2>
                <p class="text-muted mb-4">{{ __('messages.questionnaireSubtitle') }}</p>
                <div class="d-grid gap-3">
                    {{-- Tombol untuk kontak resmi --}}
                    <button onclick="prioritizeAndScrollToSection('contact')" class="btn btn-primary btn-lg text-center p-3">{{ __('messages.q1') }}</button>
                    {{-- Tombol untuk lokasi --}}
                    <button onclick="prioritizeAndScrollToSection('contact')" class="btn btn-primary btn-lg text-center p-3">{{ __('messages.q2') }}</button>
                    {{-- Tombol untuk informasi --}}
                    <button onclick="prioritizeAndScrollToSection('about')" class="btn btn-primary btn-lg text-center p-3">{{ __('messages.q3') }}</button>
                    {{-- Tombol untuk layanan --}}
                    <button onclick="prioritizeAndScrollToSection('services')" class="btn btn-primary btn-lg text-center p-3">{{ __('messages.q4') }}</button>
                </div>
                <button type="button" class="btn btn-link mt-4" data-bs-dismiss="modal">{{ __('messages.skipButton') }}</button>
            </div>
        </div>
    </div>
</div>