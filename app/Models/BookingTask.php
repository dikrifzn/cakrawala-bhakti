<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BookingTask extends Model
{
    protected $fillable = [
        'booking_id',
        'task_name',
        'start_date',
        'end_date',
        'pic',
        'order',
    ];

    public function booking(): BelongsTo
    {
        return $this->belongsTo(Booking::class);
    }
}
