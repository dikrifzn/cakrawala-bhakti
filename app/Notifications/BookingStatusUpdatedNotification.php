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
        return ['mail', 'database'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $status = ucfirst($this->booking->status ?? 'pending');
        
        return (new MailMessage)
            ->subject('Update Status Booking #' . str_pad($this->booking->id, 6, '0', STR_PAD_LEFT) . ' - ' . $status)
            ->view('emails.booking.status-updated', ['booking' => $this->booking]);
    }

    public function toDatabase(object $notifiable): array
    {
        $statusLabels = [
            'pending' => 'Pending',
            'approved' => 'Disetujui',
            'rejected' => 'Ditolak',
            'finished' => 'Selesai',
        ];
        
        $statusLabel = $statusLabels[$this->booking->status] ?? ucfirst($this->booking->status);
        
        return [
            'format' => 'filament',
            'booking_id' => $this->booking->id,
            'customer_name' => $this->booking->customer_name,
            'status' => $this->booking->status,
            'message' => 'Status pemesanan ' . $this->booking->customer_name . ' diubah menjadi: ' . $statusLabel,
            'actions' => [
                [
                    'name' => 'view',
                    'label' => 'Lihat Detail',
                    'url' => route('filament.admin.resources.bookings.edit', ['record' => $this->booking->id]),
                ],
            ],
        ];
    }

    public function toArray(object $notifiable): array
    {
        return $this->toDatabase($notifiable);
    }
}
