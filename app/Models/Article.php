<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cache;

class Article extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'content',
        'thumbnail',
        'category_id',
    ];

    protected $table = 'articles';

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function category()
    {
        return $this->belongsTo(ArticleCategory::class, 'category_id');
    }

    public function scopePublished($query)
    {
        return $query->whereNotNull('created_at');
    }

    public function scopeByCategory($query, $categoryId)
    {
        return $query->where('category_id', $categoryId);
    }

    public function scopeBySlug($query, $slug)
    {
        return $query->where('slug', $slug);
    }

    public function scopeLatest($query)
    {
        return $query->orderBy('created_at', 'desc');
    }

    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (!$model->slug) {
                $model->slug = static::generateUniqueSlug($model->title);
            } else {
                $model->slug = static::generateUniqueSlug($model->slug);
            }
        });

        static::updating(function ($model) {
            if (!$model->slug || $model->isDirty('title')) {
                $model->slug = static::generateUniqueSlug($model->title, $model->id);
            }
        });
    }

    protected static function generateUniqueSlug($value, $ignoreId = null)
    {
        $base = Str::slug($value);
        $slug = $base;
        $counter = 1;

        while (static::where('slug', $slug)->when($ignoreId, function ($q, $ignoreId) {
            return $q->where('id', '!=', $ignoreId);
        })->exists()) {
            $slug = $base . '-' . $counter++;
        }

        return $slug;
    }
}
