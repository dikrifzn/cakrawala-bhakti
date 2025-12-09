<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Builder;

class Service extends Model
{
    protected $fillable = [
        'service_name',
        'short_description',
        'icon',
        'price',
        'banner_image',
        'sort_order',
        'created_by',
    ];

    public function bookings(): BelongsToMany
    {
        return $this->belongsToMany(Booking::class, 'booking_services')
                    ->withPivot('price', 'quantity')
                    ->withTimestamps();
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Scope to get services created by admin or legacy services
     */
    public function scopeAdminServices(Builder $query): Builder
    {
        return $query->where(function ($q) {
            $q->whereHas('creator', function ($subQuery) {
                $subQuery->where('role', 'admin');
            })
            ->orWhereNull('created_by');
        });
    }
}
