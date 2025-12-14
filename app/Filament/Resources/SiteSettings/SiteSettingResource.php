<?php

namespace App\Filament\Resources\SiteSettings;

use App\Filament\Resources\SiteSettings\Pages\EditSiteSetting;
use App\Models\SiteSetting;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use UnitEnum;

class SiteSettingResource extends Resource
{
    protected static ?string $model = SiteSetting::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-cog';

    protected static ?string $recordTitleAttribute = 'site_name';
    protected static ?string $navigationLabel = 'Pengaturan Situs';
    protected static string | UnitEnum | null $navigationGroup = 'Pengaturan Website';
    protected static ?int $navigationSort = 6;

    public static function form(Schema $schema): Schema
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

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('site_name')
                    ->label('Nama Situs')
                    ->searchable(),
                TextColumn::make('tagline')
                    ->label('Tagline')
                    ->searchable(),
                TextColumn::make('address')
                    ->label('Alamat')
                    ->searchable(),
                TextColumn::make('phone')
                    ->label('Telepon')
                    ->searchable(),
                TextColumn::make('email')
                    ->label('Email')
                    ->searchable(),
                TextColumn::make('instagram')
                    ->label('Instagram')
                    ->searchable(),
                TextColumn::make('facebook')
                    ->label('Facebook')
                    ->searchable(),
                TextColumn::make('tiktok')
                    ->label('TikTok')
                    ->searchable(),
                TextColumn::make('logo_header')
                    ->label('Logo Header')
                    ->searchable(),
                TextColumn::make('logo_footer')
                    ->label('Logo Footer')
                    ->searchable(),
                TextColumn::make('created_at')
                    ->label('Dibuat pada')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->label('Diubah pada')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => EditSiteSetting::route('/'),
        ];
    }
}
