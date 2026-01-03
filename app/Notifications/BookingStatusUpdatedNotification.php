<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class BookingStatusUpdatedNotification extends Notification
{
    use Queueable;

    public function __construct(public $booking) {}

    public function via(object $notifiable): array
    {
        // Email notifications disabled - only database notifications
        return ['database'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $status = ucfirst($this->booking->admin_status ?? 'review');

        return (new MailMessage)
            ->subject('Update Status Booking #'.str_pad($this->booking->id, 6, '0', STR_PAD_LEFT).' - '.$status)
            ->view('emails.booking.status-updated', ['booking' => $this->booking]);
    }

    public function toDatabase(object $notifiable): array
    {
        $statusLabels = [
            'review' => 'Review',
            'detail_sent' => 'Detail Sent',
            'final_approved' => 'Approval Sent',
            'on_progress' => 'On Progress',
            'finished' => 'Finished',
            'rejected' => 'Rejected',
        ];

        $statusLabel = $statusLabels[$this->booking->admin_status] ?? ucfirst($this->booking->admin_status);

        return [
            'format' => 'filament',
            'booking_id' => $this->booking->id,
            'customer_name' => $this->booking->customer_name,
            'status' => $this->booking->admin_status,
            'message' => 'Status pemesanan '.$this->booking->customer_name.' diubah menjadi: '.$statusLabel,
            'actions' => [
                [
                    'name' => 'view',
                    'label' => 'Lihat Detail',
                    'url' => \App\Filament\Resources\Bookings\BookingResource::getUrl('edit', ['record' => $this->booking->id]),
                ],
            ],
        ];
    }

    public function toArray(object $notifiable): array
    {
        return $this->toDatabase($notifiable);
    }
}
