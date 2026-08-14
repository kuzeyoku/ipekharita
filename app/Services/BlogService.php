<?php

namespace App\Services;

use App\Models\BlogPost;

class BlogService extends BaseService
{
    protected string $modelClass = BlogPost::class;
    protected string $imageDirectory = 'uploads/blog';
    protected int $imageWidth = 1200;
    protected int $imageHeight = 675;
}
