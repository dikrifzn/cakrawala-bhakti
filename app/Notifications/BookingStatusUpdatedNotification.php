<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class BookingStatusUpdatedNotification extends Notification
{
    use Queueable;

    public function __construct(public $booking)
    {
    }

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $status = ucfirst($this->booking->status ?? 'pending');
        
        return (new MailMessage)
            ->subject('Update Status Booking #' . str_pad($this->booking->id, 6, '0', STR_PAD_LEFT) . ' - ' . $status)
            ->view('emails.booking.status-updated', ['booking' => $this->booking]);
    }

    public function toArray(object $notifiable): array
    {
        return [];
    }
}
