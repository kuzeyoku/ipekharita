<?php

declare(strict_types=1);

namespace App\Models\Translations;

use Illuminate\Database\Eloquent\Model;
use App\Models\Faq;

class FaqTranslation extends Model
{
    protected $fillable = [
        'faq_id',
        'locale',
        'question',
        'answer',
    ];

    public function faq()
    {
        return $this->belongsTo(Faq::class);
    }
}
