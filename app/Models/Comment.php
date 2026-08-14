<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Comment extends BaseModel
{
    use HasFactory;

    protected $fillable = [
        'blog_post_id',
        'name',
        'email',
        'comment',
        'is_approved',
        'ip_address',
    ];

    protected $casts = [
        'is_approved' => 'boolean',
    ];

    public function blogPost()
    {
        return $this->belongsTo(BlogPost::class, 'blog_post_id');
    }
}
