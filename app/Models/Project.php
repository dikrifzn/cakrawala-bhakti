<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable = [
        'project_title',
        'client_name',
        'location',
        'date',
        'description',
        'images',
    ];

    protected $casts = [
        'date' => 'date',
        'images' => 'array',
    ];
}
