<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AboutSection extends Model
{
    protected $fillable = [
        'title',
        'subtitle',
        'description',
        'image_1',
        'image_2',
        'image_3',
        'image_4',
    ];

    protected $table = 'about_sections';
}
