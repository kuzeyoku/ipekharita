<?php

namespace App\Models\Translations;

use Illuminate\Database\Eloquent\Model;
use App\Models\Category;

class CategoryTranslation extends Model
{
    protected $fillable = [
        'category_id',
        'locale',
        'title',
        'slug',
        'description',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
