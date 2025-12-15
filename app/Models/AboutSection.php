<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AboutSection extends Model
{
    protected $fillable = [
        'title',
        'subtitle',
        'description',
        'images',
    ];

    protected $table = 'about_sections';

    protected $casts = [
        'images' => 'array',
    ];
}
