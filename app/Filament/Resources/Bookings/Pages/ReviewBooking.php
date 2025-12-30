<?php

namespace App\Filament\Resources\Bookings\Pages;

use App\Filament\Resources\Bookings\BookingResource;
use App\Models\Booking;
use Filament\Resources\Pages\Page;

class ReviewBooking extends Page
{
    protected static string $resource = BookingResource::class;

    protected string $view = 'filament.resources.bookings.pages.review-booking';

    public Booking $booking;

    public function mount($record): void
    {
        $this->booking = Booking::findOrFail($record);
    }

    protected function getViewData(): array
    {
        return [
            'booking' => $this->booking,
        ];
    }
}
