<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Traits\HasTranslation;
use App\Models\Translations\SiteModalTranslation;

class SiteModal extends BaseModel
{
    use HasFactory, HasTranslation;

    protected $fillable = [
        'title',
        'content',
        'image',
        'btn_text',
        'btn_url',
        'show_delay',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'show_delay' => 'integer',
    ];

    public function translations()
    {
        return $this->hasMany(SiteModalTranslation::class);
    }

    public function getTitleAttribute($value)
    {
        return $this->getTranslatedAttribute('title') ?: $value;
    }

    public function getContentAttribute($value)
    {
        return $this->getTranslatedAttribute('content') ?: $value;
    }

    public function getBtnTextAttribute($value)
    {
        return $this->getTranslatedAttribute('btn_text') ?: $value;
    }
}
