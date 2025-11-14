<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ContentPage;

class ContentPageSeeder extends Seeder
{
    public function run(): void
    {
        // About Us - Indonesian
        ContentPage::create([
            'page_key' => 'about_us',
            'locale' => 'id',
            'title' => 'Tentang Kami',
            'content' => '<h2>Tentang Legian Medical Clinic</h2>
<p>Legian Medical Clinic adalah klinik kesehatan terpercaya yang berlokasi di jantung Legian, Bali. Kami berkomitmen untuk memberikan pelayanan kesehatan berkualitas tinggi dengan standar internasional.</p>
<p>Didirikan pada tahun 2010, klinik kami telah melayani ribuan pasien lokal maupun internasional dengan berbagai kebutuhan kesehatan. Tim dokter kami terdiri dari tenaga medis berpengalaman dan bersertifikasi.</p>
<h3>Visi Kami</h3>
<p>Menjadi klinik kesehatan terdepan yang memberikan pelayanan medis berkualitas tinggi dengan teknologi modern dan pelayanan yang ramah.</p>
<h3>Misi Kami</h3>
<p>Memberikan pelayanan kesehatan yang terjangkau, berkualitas, dan berorientasi pada kepuasan pasien dengan mengutamakan keselamatan dan kenyamanan.</p>',
            'meta_data' => [
                'address' => 'Jl. Legian No. 123, Legian, Bali',
                'phone' => '+62 361 123456',
                'email' => 'info@legianmedical.com',
                'hours' => 'Senin - Minggu: 08:00 - 20:00'
            ]
        ]);

        // About Us - English
        ContentPage::create([
            'page_key' => 'about_us',
            'locale' => 'en',
            'title' => 'About Us',
            'content' => '<h2>About Legian Medical Clinic</h2>
<p>Legian Medical Clinic is a trusted healthcare facility located in the heart of Legian, Bali. We are committed to providing high-quality healthcare services with international standards.</p>
<p>Established in 2010, our clinic has served thousands of local and international patients with various healthcare needs. Our medical team consists of experienced and certified medical professionals.</p>
<h3>Our Vision</h3>
<p>To become a leading healthcare clinic that provides high-quality medical services with modern technology and friendly service.</p>
<h3>Our Mission</h3>
<p>To provide affordable, quality healthcare services that are patient-oriented, prioritizing safety and comfort.</p>',
            'meta_data' => [
                'address' => 'Jl. Legian No. 123, Legian, Bali',
                'phone' => '+62 361 123456',
                'email' => 'info@legianmedical.com',
                'hours' => 'Monday - Sunday: 08:00 - 20:00'
            ]
        ]);

        // FAQ - Indonesian
        ContentPage::create([
            'page_key' => 'faq',
            'locale' => 'id',
            'title' => 'Pertanyaan Umum',
            'content' => '<h2>Pertanyaan Umum (FAQ)</h2>
<div class="accordion" id="faqAccordion">
    <div class="accordion-item">
        <h3 class="accordion-header">
            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#faq1">
                Apakah klinik buka 24 jam?
            </button>
        </h3>
        <div id="faq1" class="accordion-collapse collapse show" data-bs-parent="#faqAccordion">
            <div class="accordion-body">
                Klinik kami buka dari Senin hingga Minggu, pukul 08:00 - 20:00 WITA. Untuk keadaan darurat di luar jam operasional, silakan hubungi hotline kami.
            </div>
        </div>
    </div>
    <div class="accordion-item">
        <h3 class="accordion-header">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq2">
                Apakah menerima asuransi kesehatan?
            </button>
        </h3>
        <div id="faq2" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
            <div class="accordion-body">
                Ya, kami menerima berbagai jenis asuransi kesehatan. Silakan hubungi kami untuk informasi lebih detail tentang asuransi yang kami terima.
            </div>
        </div>
    </div>
    <div class="accordion-item">
        <h3 class="accordion-header">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq3">
                Apakah perlu membuat janji temu?
            </button>
        </h3>
        <div id="faq3" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
            <div class="accordion-body">
                Meskipun tidak wajib, kami sangat menyarankan untuk membuat janji temu terlebih dahulu untuk memastikan ketersediaan dokter dan mengurangi waktu tunggu.
            </div>
        </div>
    </div>
</div>',
            'meta_data' => []
        ]);

        // FAQ - English
        ContentPage::create([
            'page_key' => 'faq',
            'locale' => 'en',
            'title' => 'Frequently Asked Questions',
            'content' => '<h2>Frequently Asked Questions (FAQ)</h2>
<div class="accordion" id="faqAccordion">
    <div class="accordion-item">
        <h3 class="accordion-header">
            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#faq1">
                Is the clinic open 24 hours?
            </button>
        </h3>
        <div id="faq1" class="accordion-collapse collapse show" data-bs-parent="#faqAccordion">
            <div class="accordion-body">
                Our clinic is open from Monday to Sunday, 08:00 - 20:00 WITA. For emergencies outside operating hours, please contact our hotline.
            </div>
        </div>
    </div>
    <div class="accordion-item">
        <h3 class="accordion-header">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq2">
                Do you accept health insurance?
            </button>
        </h3>
        <div id="faq2" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
            <div class="accordion-body">
                Yes, we accept various types of health insurance. Please contact us for more detailed information about the insurance we accept.
            </div>
        </div>
    </div>
    <div class="accordion-item">
        <h3 class="accordion-header">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq3">
                Do I need to make an appointment?
            </button>
        </h3>
        <div id="faq3" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
            <div class="accordion-body">
                Although not mandatory, we highly recommend making an appointment first to ensure doctor availability and reduce waiting time.
            </div>
        </div>
    </div>
</div>',
            'meta_data' => []
        ]);

        // Contact - Indonesian
        ContentPage::create([
            'page_key' => 'contact',
            'locale' => 'id',
            'title' => 'Hubungi Kami',
            'content' => '<h2>Hubungi Kami</h2>
<div class="row">
    <div class="col-md-6">
        <h3>Informasi Kontak</h3>
        <p><strong>Alamat:</strong><br>
        Jl. Legian No. 123<br>
        Legian, Kuta, Badung<br>
        Bali 80361, Indonesia</p>
        
        <p><strong>Telepon:</strong><br>
        +62 361 123456</p>
        
        <p><strong>Email:</strong><br>
        info@legianmedical.com</p>
        
        <p><strong>Jam Operasional:</strong><br>
        Senin - Minggu: 08:00 - 20:00 WITA</p>
    </div>
</div>',
            'meta_data' => [
                'address' => 'Jl. Legian No. 123, Legian, Kuta, Badung, Bali 80361, Indonesia',
                'phone' => '+62 361 123456',
                'email' => 'info@legianmedical.com',
                'hours' => 'Senin - Minggu: 08:00 - 20:00 WITA',
                'emergency_phone' => '+62 361 123457'
            ]
        ]);

        // Contact - English
        ContentPage::create([
            'page_key' => 'contact',
            'locale' => 'en',
            'title' => 'Contact Us',
            'content' => '<h2>Contact Us</h2>
<div class="row">
    <div class="col-md-6">
        <h3>Contact Information</h3>
        <p><strong>Address:</strong><br>
        Jl. Legian No. 123<br>
        Legian, Kuta, Badung<br>
        Bali 80361, Indonesia</p>
        
        <p><strong>Phone:</strong><br>
        +62 361 123456</p>
        
        <p><strong>Email:</strong><br>
        info@legianmedical.com</p>
        
        <p><strong>Operating Hours:</strong><br>
        Monday - Sunday: 08:00 - 20:00 WITA</p>
    </div>
</div>',
            'meta_data' => [
                'address' => 'Jl. Legian No. 123, Legian, Kuta, Badung, Bali 80361, Indonesia',
                'phone' => '+62 361 123456',
                'email' => 'info@legianmedical.com',
                'hours' => 'Monday - Sunday: 08:00 - 20:00 WITA',
                'emergency_phone' => '+62 361 123457'
            ]
        ]);
    }
}

