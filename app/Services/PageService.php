<?php

namespace App\Services;

use App\Models\Page;

class PageService extends BaseService
{
    protected string $modelClass = Page::class;
    protected string $imageDirectory = 'uploads/pages';
    protected int $imageWidth = 1200;
    protected int $imageHeight = 630;
}
