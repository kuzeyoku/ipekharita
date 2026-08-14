<?php

namespace App\Models\Translations;

use Illuminate\Database\Eloquent\Model;
use App\Models\SiteModal;

class SiteModalTranslation extends Model
{
    protected $fillable = [
        'site_modal_id',
        'locale',
        'title',
        'content',
        'btn_text',
    ];

    public function siteModal()
    {
        return $this->belongsTo(SiteModal::class);
    }
}
