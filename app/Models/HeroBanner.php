<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HeroBanner extends Model
{
    protected $fillable = [
        'title',
        'highlight_text',
        'subtitle',
        'button_text',
        'button_link',
        'background_image',
    ];
}
