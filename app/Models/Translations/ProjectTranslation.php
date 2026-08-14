<?php

namespace App\Models\Translations;

use Illuminate\Database\Eloquent\Model;
use App\Models\Project;

class ProjectTranslation extends Model
{
    protected $fillable = [
        'project_id',
        'locale',
        'title',
        'slug',
        'summary',
        'description',
        'location',
        'client',
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
