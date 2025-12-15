<?php

namespace App\Filament\Resources\CallToActions\Pages;

use App\Filament\Resources\CallToActions\CallToActionResource;
use Filament\Resources\Pages\EditRecord;

class EditCallToAction extends EditRecord
{
    protected static string $resource = CallToActionResource::class;

    protected static ?string $title = 'Bagian CTA';
    protected ?string $heading = 'Bagian CTA';

    public function mount(int|string|null $record = null): void
    {
        $this->record = \App\Models\CallToAction::firstOrCreate([]);
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
