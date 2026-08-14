<?php

namespace App\Services;

use App\Models\SiteModal;

class SiteModalService extends BaseService
{
    protected string $modelClass = SiteModal::class;
    protected string $imageDirectory = 'uploads/modals';
    protected int $imageWidth = 800;
    protected int $imageHeight = 600;
}
