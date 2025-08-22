<section id="faq" class="py-5 bg-white">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="fw-bold section-title d-inline-block">{{ __('messages.faqTitle') }}</h2>
            <p class="text-muted mt-2">{{ __('messages.faqSubtitle') }}</p>
        </div>
        
        @if(isset($faqs) && $faqs->count() > 0)
            {{-- Search and Filter Section --}}
            <div class="row justify-content-center mb-4">
                <div class="col-lg-6">
                    <div class="input-group">
                        <input type="text" id="faq-search" class="form-control" placeholder="{{ __('messages.searchFaq') }}" aria-label="{{ __('messages.searchFaq') }}">
                        <button class="btn btn-outline-secondary" type="button" id="faq-search-btn">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </div>
                <div class="col-lg-3">
                    <select id="faq-category-filter" class="form-select">
                        <option value="">{{ __('messages.allCategories') }}</option>
                        @php
                            $categories = $faqs->pluck('category')->filter()->unique()->sort();
                        @endphp
                        @foreach($categories as $category)
                            <option value="{{ $category }}">{{ $category }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        @endif
        <div class="row justify-content-center">
            <div class="col-lg-8">
                @if(isset($faqs) && $faqs->count() > 0)
                    <div class="accordion" id="faq-accordion">
                        @foreach ($faqs as $index => $faq)
                        <div class="accordion-item" data-category="{{ $faq->category ?? '' }}">
                            <h2 class="accordion-header" id="heading-{{ $faq->id }}">
                                <button class="accordion-button {{ $index !== 0 ? 'collapsed' : '' }}" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-{{ $faq->id }}" aria-expanded="{{ $index === 0 ? 'true' : 'false' }}" aria-controls="collapse-{{ $faq->id }}" data-bs-parent="#faq-accordion">
                                    {{ $faq->localized_question }}
                                    @if($faq->category)
                                        <span class="badge bg-secondary ms-2">{{ $faq->category }}</span>
                                    @endif
                                </button>
                            </h2>
                            <div id="collapse-{{ $faq->id }}" class="accordion-collapse collapse {{ $index === 0 ? 'show' : '' }}" aria-labelledby="heading-{{ $faq->id }}" data-bs-parent="#faq-accordion">
                                <div class="accordion-body">
                                    {!! $faq->localized_answer !!}
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                @elseif(isset($content['faq']) && $content['faq'])
                    {{-- Fallback ke content page jika tidak ada FAQ dari database --}}
                    <div class="faq-content">
                        {!! $content['faq']->content !!}
                    </div>
                @else
                    {{-- Fallback ke hardcoded messages jika tidak ada data sama sekali --}}
                    <div class="accordion" id="faq-accordion">
                        @foreach (__('messages.faqs') as $index => $faq)
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="heading-{{ $index }}">
                                <button class="accordion-button {{ $index !== 0 ? 'collapsed' : '' }}" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-{{ $index }}" aria-expanded="{{ $index === 0 ? 'true' : 'false' }}" aria-controls="collapse-{{ $index }}" data-bs-parent="#faq-accordion">
                                    {{ $faq['question'] }}
                                </button>
                            </h2>
                            <div id="collapse-{{ $index }}" class="accordion-collapse collapse {{ $index === 0 ? 'show' : '' }}" aria-labelledby="heading-{{ $index }}" data-bs-parent="#faq-accordion">
                                <div class="accordion-body">
                                    {{ $faq['answer'] }}
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>
</section>