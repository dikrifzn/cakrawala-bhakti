<?php

namespace App\Filament\Resources\Bookings\Pages;

use App\Filament\Resources\Bookings\BookingResource;
use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditBooking extends EditRecord
{
    protected static string $resource = BookingResource::class;

    protected static ?string $title = 'Kelola Booking';

    protected ?string $heading = 'Kelola Booking Event';

    protected function getHeaderActions(): array
    {
        return [
            Action::make('review')
                ->label('Review Workflow')
                ->icon('heroicon-o-eye')
                ->color('primary')
                ->url(fn () => BookingResource::getUrl('review', ['record' => $this->record]))
                ->openUrlInNewTab(),

            DeleteAction::make(),
        ];
    }
}
