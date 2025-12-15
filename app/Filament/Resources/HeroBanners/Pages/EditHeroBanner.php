<?php

namespace App\Filament\Resources\HeroBanners\Pages;

use App\Filament\Resources\HeroBanners\HeroBannerResource;
use App\Models\HeroBanner;
use Filament\Resources\Pages\EditRecord;

class EditHeroBanner extends EditRecord
{
    protected static string $resource = HeroBannerResource::class;

    protected static ?string $title = 'Bagian Hero';
    protected ?string $heading = 'Bagian Hero';

    public function mount(int|string|null $record = null): void
    {
        $existing = HeroBanner::query()->latest('id')->first();

        if (! $existing) {
            $existing = HeroBanner::create([
                'title' => '',
                'highlight_text' => '',
                'subtitle' => '',
                'button_text' => '',
                'button_link' => '',
                'background_image' => null,
            ]);
        }

        $this->record = $existing;
        
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
