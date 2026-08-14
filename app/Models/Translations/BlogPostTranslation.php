<?php

namespace App\Models\Translations;

use Illuminate\Database\Eloquent\Model;
use App\Models\BlogPost;

class BlogPostTranslation extends Model
{
    protected $fillable = [
        'blog_post_id',
        'locale',
        'title',
        'slug',
        'summary',
        'content',
    ];

    public function post()
    {
        return $this->belongsTo(BlogPost::class, 'blog_post_id');
    }
}
