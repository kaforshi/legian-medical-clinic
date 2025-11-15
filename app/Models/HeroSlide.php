<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class HeroSlide extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title_id',
        'title_en',
        'subtitle_id',
        'subtitle_en',
        'image',
        'button_text_id',
        'button_text_en',
        'button_link',
        'sort_order',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];

    public function getImageUrlAttribute()
    {
        if ($this->image) {
            return asset('storage/' . $this->image);
        }
        return asset('images/hero.jpg'); // Default hero image
    }

    // Accessors for localized content
    public function getLocalizedTitleAttribute()
    {
        $locale = app()->getLocale();
        if ($locale === 'id') {
            return $this->title_id ?? '';
        }
        return $this->title_en ?? '';
    }

    public function getLocalizedSubtitleAttribute()
    {
        $locale = app()->getLocale();
        if ($locale === 'id') {
            return $this->subtitle_id ?? '';
        }
        return $this->subtitle_en ?? '';
    }

    public function getLocalizedButtonTextAttribute()
    {
        $locale = app()->getLocale();
        if ($locale === 'id') {
            return $this->button_text_id ?? 'Buat Janji Temu';
        }
        return $this->button_text_en ?? 'Book Appointment';
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order', 'asc');
    }
}
