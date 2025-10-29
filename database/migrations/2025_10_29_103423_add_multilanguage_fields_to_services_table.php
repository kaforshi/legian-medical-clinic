<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('services', function (Blueprint $table) {
            // Add multilingual fields
            $table->string('name_id')->nullable()->after('name');
            $table->string('name_en')->nullable()->after('name_id');
            $table->text('description_id')->nullable()->after('description');
            $table->text('description_en')->nullable()->after('description_id');
        });

        // Migrate existing data
        \DB::table('services')->get()->each(function ($service) {
            \DB::table('services')
                ->where('id', $service->id)
                ->update([
                    'name_id' => $service->name,
                    'name_en' => $service->name, // Copy same value as default
                    'description_id' => $service->description,
                    'description_en' => $service->description, // Copy same value as default
                ]);
        });

        // Make old fields nullable (for backward compatibility)
        Schema::table('services', function (Blueprint $table) {
            $table->string('name')->nullable()->change();
            $table->text('description')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('services', function (Blueprint $table) {
            // Migrate data back before dropping
            \DB::table('services')->get()->each(function ($service) {
                \DB::table('services')
                    ->where('id', $service->id)
                    ->update([
                        'name' => $service->name_id ?? $service->name_en,
                        'description' => $service->description_id ?? $service->description_en,
                    ]);
            });

            $table->string('name')->nullable(false)->change();
            $table->text('description')->nullable(false)->change();
            $table->dropColumn(['name_id', 'name_en', 'description_id', 'description_en']);
        });
    }
};
