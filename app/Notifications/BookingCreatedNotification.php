<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class BookingCreatedNotification extends Notification
{
    use Queueable;

    public $booking;

    /**
     * Create a new notification instance.
     */
    public function __construct($booking)
    {
        $this->booking = $booking;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Konfirmasi Booking #'.str_pad($this->booking->id, 6, '0', STR_PAD_LEFT).' - Cakrawala Bhakti')
            ->view('emails.booking.created', [
                'booking' => $this->booking,
            ]);
    }

    /**
     * Get the database representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toDatabase(object $notifiable): array
    {
        return [
            'format' => 'filament',
            'booking_id' => $this->booking->id,
            'customer_name' => $this->booking->customer_name,
            'event_type' => $this->booking->event_name,
            'message' => 'Pemesanan baru dari '.$this->booking->customer_name,
            'actions' => [
                [
                    'name' => 'view',
                    'label' => 'Lihat Detail',
                    'url' => \App\Filament\Resources\Bookings\BookingResource::getUrl('edit', ['record' => $this->booking->id]),
                ],
            ],
        ];
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return $this->toDatabase($notifiable);
    }
}
