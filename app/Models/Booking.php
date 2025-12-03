<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $fillable = [
        'customer_name',
        'customer_email',
        'customer_phone',
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

    public function eventType()
    {
        return $this->belongsTo(EventType::class);
    }

    public function services()
    {
        return $this->belongsToMany(Service::class, 'booking_services')
                    ->withPivot('price', 'quantity')
                    ->withTimestamps();
    }
}
