<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Message extends BaseModel
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'subject',
        'service_title',
        'message',
        'is_read',
    ];

    protected $casts = [
        'is_read' => 'boolean',
    ];
}
