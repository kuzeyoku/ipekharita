<?php

namespace App\Services;

use App\Models\Service;

class ServiceService extends BaseService
{
    protected string $modelClass = Service::class;
    protected string $imageDirectory = 'uploads/services';
    protected int $imageWidth = 800;
    protected int $imageHeight = 600;
}
