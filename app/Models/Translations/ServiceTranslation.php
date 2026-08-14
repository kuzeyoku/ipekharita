<?php

namespace App\Models\Translations;

use Illuminate\Database\Eloquent\Model;
use App\Models\Service;

class ServiceTranslation extends Model
{
    protected $fillable = [
        'service_id',
        'locale',
        'title',
        'slug',
        'summary',
        'content',
    ];

    public function service()
    {
        return $this->belongsTo(Service::class);
    }
}
