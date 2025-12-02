<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BlogPost extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'content',
        'thumbnail',
        'category_id',
    ];

    public function category()
    {
        return $this->belongsTo(BlogCategory::class, 'category_id');
    }
}
