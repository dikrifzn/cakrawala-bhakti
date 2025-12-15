<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectImage extends Model
{
    protected $fillable = [
        'project_id',
        'image',
        'sort_order',
    ];

    protected $casts = [
        'image' => 'json',
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
