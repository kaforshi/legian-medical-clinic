<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContentPage extends Model
{
    use HasFactory;

    protected $fillable = [
        'page_key',
        'locale',
        'title',
        'content',
        'meta_data'
    ];

    protected $casts = [
        'meta_data' => 'array',
    ];

    public function scopeByPage($query, $pageKey)
    {
        return $query->where('page_key', $pageKey);
    }

    public function scopeByLocale($query, $locale)
    {
        return $query->where('locale', $locale);
    }

    public function getMetaDataValue($key, $default = null)
    {
        return $this->meta_data[$key] ?? $default;
    }
}

