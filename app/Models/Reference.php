<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Reference extends BaseModel
{
    use HasFactory;

    protected $fillable = [
        'title',
        'logo',
        'url',
        'order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'order' => 'integer',
    ];
}
