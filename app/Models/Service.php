<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'name_id',
        'name_en',
        'description',
        'description_id',
        'description_en',
        'icon',
        'price',
        'is_active',
        'sort_order'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'price' => 'decimal:2',
    ];

    public function getIconUrlAttribute()
    {
        if ($this->icon) {
            return asset('storage/' . $this->icon);
        }
        return asset('images/default-icon.png');
    }

    // Accessors for localized content
    public function getLocalizedNameAttribute()
    {
        $locale = app()->getLocale();
        if ($locale === 'id') {
            return $this->name_id ?? $this->name ?? '';
        }
        return $this->name_en ?? $this->name ?? '';
    }

    public function getLocalizedDescriptionAttribute()
    {
        $locale = app()->getLocale();
        if ($locale === 'id') {
            return $this->description_id ?? $this->description ?? '';
        }
        return $this->description_en ?? $this->description ?? '';
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

