<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Service;
use App\Models\Doctor;
use App\Models\Faq;
use App\Services\TranslationService;

class RetranslateData extends Command
{
    protected $signature = 'translate:retranslate';
    protected $description = 'Re-translate all existing data from Indonesian to English';

    public function handle(TranslationService $translationService)
    {
        $this->info('Starting re-translation process...');

        // Re-translate Services
        $this->info('Re-translating Services...');
        $services = Service::whereNotNull('name_id')->get();
        $bar = $this->output->createProgressBar($services->count());
        $bar->start();

        foreach ($services as $service) {
            if ($service->name_id && (!$service->name_en || $service->name_en === $service->name_id)) {
                $service->name_en = $translationService->translateToEnglish($service->name_id);
            }
            if ($service->description_id && (!$service->description_en || $service->description_en === $service->description_id)) {
                $service->description_en = $translationService->translateToEnglish($service->description_id);
            }
            $service->save();
            $bar->advance();
        }
        $bar->finish();
        $this->newLine();

        // Re-translate Doctors
        $this->info('Re-translating Doctors...');
        $doctors = Doctor::whereNotNull('name_id')->get();
        $bar = $this->output->createProgressBar($doctors->count());
        $bar->start();

        foreach ($doctors as $doctor) {
            // Name tidak di-translate, set name_en sama dengan name_id
            if ($doctor->name_id) {
                $doctor->name_en = $doctor->name_id;
            }
            // Translate specialization if needed
            if ($doctor->specialization_id && (empty($doctor->specialization_en) || $doctor->specialization_en === $doctor->specialization_id)) {
                $translatedSpec = $translationService->translateToEnglish($doctor->specialization_id);
                if (!empty($translatedSpec) && $translatedSpec !== $doctor->specialization_id) {
                    $doctor->specialization_en = $translatedSpec;
                }
            }
            $doctor->save();
            $bar->advance();
        }
        $bar->finish();
        $this->newLine();

        // Re-translate FAQs
        $this->info('Re-translating FAQs...');
        $faqs = Faq::whereNotNull('question_id')->get();
        $bar = $this->output->createProgressBar($faqs->count());
        $bar->start();

        foreach ($faqs as $faq) {
            if ($faq->question_id && (!$faq->question_en || $faq->question_en === $faq->question_id)) {
                $faq->question_en = $translationService->translateToEnglish($faq->question_id);
            }
            if ($faq->answer_id && (!$faq->answer_en || $faq->answer_en === $faq->answer_id)) {
                $faq->answer_en = $translationService->translateToEnglish($faq->answer_id);
            }
            $faq->save();
            $bar->advance();
        }
        $bar->finish();
        $this->newLine();

        $this->info('Re-translation completed!');
        return 0;
    }
}

