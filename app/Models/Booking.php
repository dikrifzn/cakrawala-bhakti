<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Booking extends Model
{
    protected $fillable = [
        'user_id',
        'customer_name',
        'customer_email',
        'customer_phone',
        'event_name',
        'event_type_id',
        'start_date',
        'end_date',
        'start_time',
        'end_time',
        'total_days',
        'location',
        'notes',
        'total_price',
        'status',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function eventType(): BelongsTo
    {
        return $this->belongsTo(EventType::class);
    }

    public function bookingServices(): HasMany
    {
        return $this->hasMany(BookingService::class);
    }

    public function services()
    {
        return $this->belongsToMany(Service::class, 'booking_services')
                    ->withPivot('price', 'quantity')
                    ->withTimestamps();
    }

    /**
     * Get service names as comma-separated string
     */
    protected function serviceNames(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->bookingServices
                ->map(fn ($bs) => $bs->service?->service_name ?? 'Unknown')
                ->filter()
                ->join(', ') ?: '-',
        );
    }
}
