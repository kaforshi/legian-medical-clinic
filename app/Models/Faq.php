<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Faq extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'question_id',
        'question_en',
        'answer_id',
        'answer_en',
        'category',
        'sort_order',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'sort_order' => 'integer'
    ];

    // Accessors for localized content
    public function getLocalizedQuestionAttribute()
    {
        $locale = app()->getLocale();
        return $locale === 'id' ? $this->question_id : $this->question_en;
    }

    public function getLocalizedAnswerAttribute()
    {
        $locale = app()->getLocale();
        return $locale === 'id' ? $this->answer_id : $this->answer_en;
    }

    // Scope for active FAQs
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    // Scope for ordered FAQs
    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order');
    }
}
