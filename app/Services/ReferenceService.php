<?php

namespace App\Services;

use App\Models\Reference;

class ReferenceService extends BaseService
{
    protected string $modelClass = Reference::class;
    protected string $imageDirectory = 'uploads/references';
    protected string $imageColumn = 'logo';
    protected int $imageWidth = 400;
    protected int $imageHeight = 200;
}
