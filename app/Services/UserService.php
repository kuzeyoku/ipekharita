<?php

namespace App\Services;

use App\Models\User;

class UserService extends BaseService
{
    protected string $modelClass = User::class;
}
