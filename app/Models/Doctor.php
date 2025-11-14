<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'name_id',
        'name_en',
        'specialization',
        'specialization_id',
        'specialization_en',
        'photo',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function getPhotoUrlAttribute()
    {
        if ($this->photo) {
            return asset('storage/' . $this->photo);
        }
        return asset('images/default-doctor.jpg');
    }

    // Accessors for localized content
    public function getLocalizedNameAttribute()
    {
        // Nama dokter tidak di-translate, tetap sama untuk semua bahasa
        return $this->name_id ?? $this->name ?? '';
    }

    public function getLocalizedSpecializationAttribute()
    {
        $locale = app()->getLocale();
        if ($locale === 'id') {
            return $this->specialization_id ?? $this->specialization ?? '';
        }
        return $this->specialization_en ?? $this->specialization ?? '';
    }
}

