<section id="faq" class="py-5 bg-white">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="fw-bold section-title d-inline-block">{{ __('messages.faqTitle') }}</h2>
            <p class="text-muted mt-2">{{ __('messages.faqSubtitle') }}</p>
        </div>
        <div class="row justify-content-center">
            <div class="col-lg-8">
                @if($faqs->count() > 0)
                    <div class="accordion" id="faq-accordion">
                        @foreach($faqs as $index => $faq)
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="heading-{{ $faq->id }}">
                                    <button class="accordion-button {{ $index !== 0 ? 'collapsed' : '' }}" 
                                            type="button" 
                                            data-bs-toggle="collapse" 
                                            data-bs-target="#collapse-{{ $faq->id }}" 
                                            aria-expanded="{{ $index === 0 ? 'true' : 'false' }}" 
                                            aria-controls="collapse-{{ $faq->id }}">
                                        {{ $faq->localized_question }}
                                    </button>
                                </h2>
                                <div id="collapse-{{ $faq->id }}" 
                                     class="accordion-collapse collapse {{ $index === 0 ? 'show' : '' }}" 
                                     aria-labelledby="heading-{{ $faq->id }}" 
                                     data-bs-parent="#faq-accordion">
                                    <div class="accordion-body">
                                        {!! $faq->localized_answer !!}
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-4">
                        <i class="fas fa-question-circle fa-3x text-muted mb-3"></i>
                        <h5 class="text-muted">{{ __('messages.noFaqs') }}</h5>
                        <p class="text-muted">{{ __('messages.noFaqsMessage') }}</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</section>