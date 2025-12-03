<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class ArticleCategory extends Model
{
    protected $fillable = [
        'name',
        'slug',
    ];

    protected $table = 'article_categories';

    // Relationships
    public function articles()
    {
        return $this->hasMany(Article::class, 'category_id');
    }

    // Scopes
    public function scopeBySlug($query, $slug)
    {
        return $query->where('slug', $slug);
    }

    // Mutators
    public static function boot()
    {
        parent::boot();

        // Auto-generate slug from name
        static::creating(function ($model) {
            if (!$model->slug) {
                $model->slug = Str::slug($model->name);
            }
        });

        static::updating(function ($model) {
            if (!$model->slug || $model->isDirty('name')) {
                $model->slug = Str::slug($model->name);
            }
        });
    }
}
