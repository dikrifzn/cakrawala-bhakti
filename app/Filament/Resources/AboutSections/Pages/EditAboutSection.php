<?php

namespace App\Filament\Resources\AboutSections\Pages;

use App\Filament\Resources\AboutSections\AboutSectionResource;
use App\Models\AboutSection;
use Filament\Resources\Pages\EditRecord;

class EditAboutSection extends EditRecord
{
    protected static string $resource = AboutSectionResource::class;

    protected static ?string $title = 'Bagian Tentang';
    protected ?string $heading = 'Bagian Tentang';

    public function mount(int|string|null $record = null): void
    {
        $this->record = AboutSection::firstOrCreate([]);
        
        $this->fillForm();

        $this->previousUrl = static::getResource()::getUrl('index');
    }

    protected function getHeaderActions(): array
    {
        return [];
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        $data['images'] = isset($data['images']) && is_array($data['images'])
            ? array_values(array_filter($data['images']))
            : [];

        return $data;
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $images = isset($data['images']) && is_array($data['images'])
            ? array_values(array_filter($data['images']))
            : [];

        $data['images'] = $images;

        return $data;
    }

    protected function getRedirectUrl(): string
    {
        return static::getResource()::getUrl('index');
    }
}
