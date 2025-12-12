<?php

namespace App\Filament\Resources\Bookings\Pages;

use App\Filament\Resources\Bookings\BookingResource;
use App\Models\Booking;
use App\Models\BookingService;
use App\Models\User;
use App\Notifications\BookingStatusUpdatedNotification;
use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Notification;

class EditBooking extends EditRecord
{
    protected static string $resource = BookingResource::class;

    protected static ?string $title = 'Ubah Pemesanan';
    protected ?string $heading = 'Ubah Pemesanan';

    protected function afterSave(): void
    {
        $statusChanged = $this->record->wasChanged('status');

        // Notify customer when status updated by admin/manager
        if ($statusChanged && $this->record->customer_email) {
            $this->record->load(['services' => fn ($query) => $query->withPivot('price', 'quantity')]);

            Notification::route('mail', $this->record->customer_email)
                ->notify(new BookingStatusUpdatedNotification($this->record));
            
            // Notify all admins in database
            $admins = \App\Models\User::where('role', 'admin')->get();
            Notification::send($admins, new BookingStatusUpdatedNotification($this->record));
        }
    }

    protected function getHeaderActions(): array
    {
        return [
            // Approve button - show when status is pending or rejected
            Action::make('approve')
                ->label('Approve')
                ->icon('heroicon-o-check-circle')
                ->color('success')
                ->visible(fn () => in_array($this->record->status, ['pending', 'rejected']))
                ->requiresConfirmation()
                ->action(function () {
                    $this->record->update(['status' => 'approved']);
                    $this->notifyStatusChange();
                    $this->redirect(static::getResource()::getUrl('edit', ['record' => $this->record]));
                }),
            
            // Reject button - show when status is pending or approved
            Action::make('reject')
                ->label('Reject')
                ->icon('heroicon-o-x-circle')
                ->color('danger')
                ->visible(fn () => in_array($this->record->status, ['pending', 'approved']))
                ->requiresConfirmation()
                ->action(function () {
                    $this->record->update(['status' => 'rejected']);
                    $this->notifyStatusChange();
                    $this->redirect(static::getResource()::getUrl('edit', ['record' => $this->record]));
                }),
            
            // Finish button - show when status is approved
            Action::make('finish')
                ->label('Selesaikan')
                ->icon('heroicon-o-flag')
                ->color('info')
                ->visible(fn () => $this->record->status === 'approved')
                ->requiresConfirmation()
                ->action(function () {
                    $this->record->update(['status' => 'finished']);
                    $this->notifyStatusChange();
                    $this->redirect(static::getResource()::getUrl('edit', ['record' => $this->record]));
                }),
            
            DeleteAction::make(),
        ];
    }
    
    protected function notifyStatusChange(): void
    {
        $this->record->load(['services' => fn ($query) => $query->withPivot('price', 'quantity')]);
        
        if ($this->record->customer_email) {
            Notification::route('mail', $this->record->customer_email)
                ->notify(new BookingStatusUpdatedNotification($this->record));
        }
        
        $admins = User::where('role', 'admin')->get();
        if ($admins->isNotEmpty()) {
            Notification::send($admins, new BookingStatusUpdatedNotification($this->record));
        }
    }
}
