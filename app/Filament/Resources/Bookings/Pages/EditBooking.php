<?php

namespace App\Filament\Resources\Bookings\Pages;

use App\Filament\Resources\Bookings\BookingResource;
use App\Models\BookingService;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditBooking extends EditRecord
{
    protected static string $resource = BookingResource::class;

    protected function mutateFormDataBeforeFill(array $data): array
    {
        // Populate selectedServices from bookingServices
        $data['selectedServices'] = $this->record->bookingServices->pluck('service_id')->toArray();
        return $data;
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        // Remove selectedServices from data to save
        unset($data['selectedServices']);
        return $data;
    }

    protected function afterSave(): void
    {
        $selectedServices = $this->form->getRawState()['selectedServices'] ?? [];
        
        // Delete existing booking services
        $this->record->bookingServices()->delete();
        
        // Create new booking services
        foreach ($selectedServices as $serviceId) {
            $service = \App\Models\Service::find($serviceId);
            if ($service) {
                BookingService::create([
                    'booking_id' => $this->record->id,
                    'service_id' => $serviceId,
                    'price' => $service->price ?? 0,
                    'quantity' => 1,
                ]);
            }
        }
    }

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
