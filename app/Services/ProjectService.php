<?php

namespace App\Services;

use App\Models\Project;

class ProjectService extends BaseService
{
    protected string $modelClass = Project::class;
    protected string $imageDirectory = 'uploads/projects';
    protected int $imageWidth = 1200;
    protected int $imageHeight = 800;
}
