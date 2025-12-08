<?php

namespace App\Filament\Resources\SiteSettings\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\FileUpload;
use Filament\Schemas\Schema;

class SiteSettingForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('site_name')
                    ->label('Nama Website'),
                TextInput::make('tagline')
                    ->label('Tagline'),
                Textarea::make('footer_description')
                    ->label('Deskripsi Footer')
                    ->rows(3)
                    ->columnSpanFull(),
                TextInput::make('address')
                    ->label('Alamat'),
                TextInput::make('phone')
                    ->label('Telepon')
                    ->tel(),
                TextInput::make('email')
                    ->label('Email Kontak')
                    ->email(),
                TextInput::make('admin_email')
                    ->label('Email Admin (Notifikasi Booking)')
                    ->email()
                    ->required()
                    ->helperText('Email utama untuk menerima notifikasi booking'),
                TextInput::make('manager_email')
                    ->label('Email Manager (Notifikasi Booking)')
                    ->email()
                    ->helperText('Email tambahan untuk menerima notifikasi booking (opsional)'),
                TextInput::make('instagram')
                    ->label('Instagram URL')
                    ->url(),
                TextInput::make('facebook')
                    ->label('Facebook URL')
                    ->url(),
                TextInput::make('tiktok')
                    ->label('TikTok URL')
                    ->url(),
                FileUpload::make('logo_header')
                    ->label('Logo Header')
                    ->disk('public')
                    ->image()
                    ->maxSize(2048),
                FileUpload::make('logo_footer')
                    ->label('Logo Footer')
                    ->disk('public')
                    ->image()
                    ->maxSize(2048),
            ]);
    }
}
