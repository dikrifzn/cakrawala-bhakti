<?php

namespace App\Filament\Resources\SiteSettings\Pages;

use App\Filament\Resources\SiteSettings\SiteSettingResource;
use App\Models\SiteSetting;
use Filament\Resources\Pages\EditRecord;

class EditSiteSetting extends EditRecord
{
    protected static string $resource = SiteSettingResource::class;

    protected static ?string $title = 'Pengaturan Situs';
    protected ?string $heading = 'Pengaturan Situs';

    public function mount(int|string|null $record = null): void
    {
        $this->record = SiteSetting::firstOrCreate([]);
        
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
