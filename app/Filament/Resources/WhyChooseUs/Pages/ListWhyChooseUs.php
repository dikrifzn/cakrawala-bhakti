<?php

namespace App\Filament\Resources\WhyChooseUs\Pages;

use App\Filament\Resources\WhyChooseUs\WhyChooseUsResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListWhyChooseUs extends ListRecords
{
    protected static string $resource = WhyChooseUsResource::class;

    protected static ?string $title = 'Bagian Alasan Memilih Kami';
    protected ?string $heading = 'Bagian Alasan Memilih Kami';

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
