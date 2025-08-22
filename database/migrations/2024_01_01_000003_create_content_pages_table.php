<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('content_pages', function (Blueprint $table) {
            $table->id();
            $table->string('page_key'); // about_us, faq, contact
            $table->string('locale', 2); // id, en
            $table->string('title');
            $table->longText('content');
            $table->json('meta_data')->nullable(); // untuk data tambahan seperti alamat, email, dll
            $table->timestamps();
            
            $table->unique(['page_key', 'locale']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('content_pages');
    }
};

