<?php

namespace App\Filament\Resources\WhyChooseUs\Pages;

use App\Filament\Resources\WhyChooseUs\WhyChooseUsResource;
use App\Models\WhyChooseUs;
use Filament\Resources\Pages\EditRecord;

class EditWhyChooseUs extends EditRecord
{
    protected static string $resource = WhyChooseUsResource::class;

    protected static ?string $title = 'Why Choose Us';

    public function mount(int|string|null $record = null): void
    {
        $this->record = WhyChooseUs::firstOrCreate([]);
        
        $this->fillForm();

        $this->previousUrl = static::getResource()::getUrl('index');
    }

    protected function getHeaderActions(): array
    {
        return [];
    }

    protected function getRedirectUrl(): string
    {
        return static::getResource()::getUrl('index');
    }
}
