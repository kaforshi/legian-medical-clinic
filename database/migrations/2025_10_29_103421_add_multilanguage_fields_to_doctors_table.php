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
        Schema::table('doctors', function (Blueprint $table) {
            // Add multilingual fields
            $table->string('name_id')->nullable()->after('name');
            $table->string('name_en')->nullable()->after('name_id');
            $table->string('specialization_id')->nullable()->after('specialization');
            $table->string('specialization_en')->nullable()->after('specialization_id');
        });

        // Migrate existing data
        \DB::table('doctors')->get()->each(function ($doctor) {
            \DB::table('doctors')
                ->where('id', $doctor->id)
                ->update([
                    'name_id' => $doctor->name,
                    'name_en' => $doctor->name, // Copy same value as default
                    'specialization_id' => $doctor->specialization,
                    'specialization_en' => $doctor->specialization, // Copy same value as default
                ]);
        });

        // Make old fields nullable (for backward compatibility, will be removed later)
        Schema::table('doctors', function (Blueprint $table) {
            $table->string('name')->nullable()->change();
            $table->string('specialization')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('doctors', function (Blueprint $table) {
            // Migrate data back before dropping
            \DB::table('doctors')->get()->each(function ($doctor) {
                \DB::table('doctors')
                    ->where('id', $doctor->id)
                    ->update([
                        'name' => $doctor->name_id ?? $doctor->name_en,
                        'specialization' => $doctor->specialization_id ?? $doctor->specialization_en,
                    ]);
            });

            $table->string('name')->nullable(false)->change();
            $table->string('specialization')->nullable(false)->change();
            $table->dropColumn(['name_id', 'name_en', 'specialization_id', 'specialization_en']);
        });
    }
};
