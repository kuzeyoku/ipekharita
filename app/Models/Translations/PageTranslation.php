<?php

namespace App\Models\Translations;

use Illuminate\Database\Eloquent\Model;
use App\Models\Page;

class PageTranslation extends Model
{
    protected $fillable = [
        'page_id',
        'locale',
        'title',
        'slug',
        'summary',
        'content',
        'meta_description',
    ];

    public function page()
    {
        return $this->belongsTo(Page::class);
    }
}
