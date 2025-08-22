<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Faq;

class FaqSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faqs = [
            [
                'question_id' => 'Apa saja layanan yang tersedia di Legian Medical Clinic?',
                'question_en' => 'What services are available at Legian Medical Clinic?',
                'answer_id' => 'Legian Medical Clinic menyediakan berbagai layanan kesehatan termasuk konsultasi dokter umum, pemeriksaan kesehatan, vaksinasi, dan layanan darurat 24/7.',
                'answer_en' => 'Legian Medical Clinic provides various health services including general practitioner consultation, health check-ups, vaccination, and 24/7 emergency services.',
                'category' => 'general',
                'sort_order' => 1,
                'is_active' => true
            ],
            [
                'question_id' => 'Bagaimana cara membuat janji temu dengan dokter?',
                'question_en' => 'How do I make an appointment with a doctor?',
                'answer_id' => 'Anda dapat membuat janji temu melalui telepon, WhatsApp, atau datang langsung ke klinik. Kami juga menyediakan layanan online booking untuk kenyamanan Anda.',
                'answer_en' => 'You can make an appointment by phone, WhatsApp, or by visiting the clinic directly. We also provide online booking services for your convenience.',
                'category' => 'appointment',
                'sort_order' => 2,
                'is_active' => true
            ],
            [
                'question_id' => 'Apakah klinik menerima asuransi kesehatan?',
                'question_en' => 'Does the clinic accept health insurance?',
                'answer_id' => 'Ya, kami menerima berbagai jenis asuransi kesehatan. Silakan hubungi tim administrasi kami untuk informasi lebih lanjut tentang kerjasama asuransi.',
                'answer_en' => 'Yes, we accept various types of health insurance. Please contact our administration team for more information about insurance partnerships.',
                'category' => 'payment',
                'sort_order' => 3,
                'is_active' => true
            ],
            [
                'question_id' => 'Berapa lama waktu tunggu untuk konsultasi?',
                'question_en' => 'How long is the waiting time for consultation?',
                'answer_id' => 'Waktu tunggu bervariasi tergantung jumlah pasien. Untuk pasien dengan janji temu, waktu tunggu biasanya 15-30 menit. Untuk walk-in, waktu tunggu bisa 30-60 menit.',
                'answer_en' => 'Waiting time varies depending on the number of patients. For patients with appointments, waiting time is usually 15-30 minutes. For walk-ins, waiting time can be 30-60 minutes.',
                'category' => 'appointment',
                'sort_order' => 4,
                'is_active' => true
            ],
            [
                'question_id' => 'Apakah tersedia layanan darurat di malam hari?',
                'question_en' => 'Is emergency service available at night?',
                'answer_id' => 'Ya, Legian Medical Clinic menyediakan layanan darurat 24/7. Tim medis kami siap memberikan pertolongan darurat kapan saja.',
                'answer_en' => 'Yes, Legian Medical Clinic provides 24/7 emergency services. Our medical team is ready to provide emergency assistance anytime.',
                'category' => 'medical',
                'sort_order' => 5,
                'is_active' => true
            ],
            [
                'question_id' => 'Apa saja fasilitas yang tersedia di klinik?',
                'question_en' => 'What facilities are available at the clinic?',
                'answer_id' => 'Klinik kami dilengkapi dengan ruang konsultasi, ruang pemeriksaan, laboratorium, apotek, dan ruang tunggu yang nyaman. Semua fasilitas didesain untuk kenyamanan pasien.',
                'answer_en' => 'Our clinic is equipped with consultation rooms, examination rooms, laboratory, pharmacy, and comfortable waiting areas. All facilities are designed for patient comfort.',
                'category' => 'facility',
                'sort_order' => 6,
                'is_active' => true
            ]
        ];

        foreach ($faqs as $faq) {
            Faq::create($faq);
        }
    }
}
