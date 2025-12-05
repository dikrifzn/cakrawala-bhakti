<?php

namespace App\Filament\Resources\SiteSettings\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class SiteSettingForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('site_name'),
                TextInput::make('tagline'),
                Textarea::make('footer_description')
                    ->columnSpanFull(),
                TextInput::make('address'),
                TextInput::make('phone')
                    ->tel(),
                TextInput::make('email')
                    ->label('Email address')
                    ->email(),
                TextInput::make('instagram'),
                TextInput::make('facebook'),
                TextInput::make('tiktok'),
                TextInput::make('logo_header'),
                TextInput::make('logo_footer'),
            ]);
    }
}
