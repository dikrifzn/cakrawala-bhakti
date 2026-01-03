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
        'pic_contact',
        'proposal_file',
        'proposal_description',
        'signature_file',
        'approval_file',
        'gantt_chart',
        'event_name',
        'start_date',
        'end_date',
        'location',
        'notes',
        'admin_status',
        'customer_status',
        'approved_by',
        'approved_at',
        'approval_ip',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'approved_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function bookingServices(): HasMany
    {
        return $this->hasMany(BookingService::class);
    }

    public function details(): HasMany
    {
        return $this->hasMany(BookingDetail::class);
    }

    public function tasks(): HasMany
    {
        return $this->hasMany(BookingTask::class);
    }

}
