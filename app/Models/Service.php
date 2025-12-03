<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $fillable = [
        'service_name',
        'short_description',
        'icon',
        'price',
        'banner_image',
        'sort_order',
    ];

    public function bookings()
    {
        return $this->belongsToMany(Booking::class, 'booking_services')
                    ->withPivot('price', 'quantity')
                    ->withTimestamps();
    }
}
