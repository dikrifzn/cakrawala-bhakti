<?php

namespace App\Filament\Resources\Bookings\Pages;

use App\Filament\Resources\Bookings\BookingResource;
use App\Models\BookingService;
use Filament\Resources\Pages\CreateRecord;

class CreateBooking extends CreateRecord
{
    protected static string $resource = BookingResource::class;

    protected function mutateFormDataBeforeSave(array $data): array
    {
        // Remove selectedServices from data to save
        unset($data['selectedServices']);
        return $data;
    }

    protected function afterCreate(): void
    {
        $selectedServices = $this->form->getRawState()['selectedServices'] ?? [];
        
        // Create booking services
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
}
