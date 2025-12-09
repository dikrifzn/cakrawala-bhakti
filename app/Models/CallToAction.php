<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CallToAction extends Model
{
    protected $fillable = [
        'title',
        'highlight_text',
        'subtitle',
        'background_image',
    ];
}
