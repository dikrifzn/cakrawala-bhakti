<?php

namespace App\Filament\Resources\Bookings\Pages;

use App\Filament\Resources\Bookings\BookingResource;
use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Pages\EditRecord;
use Filament\Notifications\Notification;

class EditBooking extends EditRecord
{
    protected static string $resource = BookingResource::class;

    protected static ?string $title = 'Kelola Booking';

    protected ?string $heading = 'Kelola Booking Event';

    protected function getHeaderActions(): array
    {
        $status = $this->record->admin_status;
        $customerStatus = $this->record->customer_status;

        return [
            // Step 1: Approve/Reject
            Action::make('approve')
                ->label('✓ Setujui')
                ->icon('heroicon-o-check-circle')
                ->color('success')
                ->visible(fn () => $status === 'review')
                ->requiresConfirmation()
                ->modalDescription('Setujui proposal dan lanjut ke input rincian jasa?')
                ->action(fn () => $this->record->update(['admin_status' => 'approved'])),

            Action::make('reject')
                ->label('✗ Tolak')
                ->icon('heroicon-o-x-circle')
                ->color('danger')
                ->visible(fn () => $status === 'review')
                ->requiresConfirmation()
                ->action(fn () => $this->record->update(['admin_status' => 'rejected'])),

            // Step 2: Send Details
            Action::make('send_details')
                ->label('➤ Kirim Rincian')
                ->icon('heroicon-o-paper-airplane')
                ->color('warning')
                ->visible(fn () => $status === 'approved')
                ->form([
                    Repeater::make('details')
                        ->relationship('details')
                        ->schema([
                            TextInput::make('service_name')
                                ->label('Nama Jasa')
                                ->required()
                                ->placeholder('Dekorasi, Catering, etc'),
                            TextInput::make('price')
                                ->label('Harga')
                                ->numeric()
                                ->required(),
                            TextInput::make('notes')
                                ->label('Catatan')
                                ->placeholder('Opsional'),
                        ])
                        ->minItems(1)
                        ->addActionLabel('+ Tambah Jasa')
                        ->collapsible(),
                ])
                ->action(function (array $data) {
                    // The Repeater uses ->relationship('details') so Filament
                    // will sync the related BookingDetail records automatically.
                    // Avoid manual delete/create to prevent races with Filament's
                    // internal persistence.
                    $this->record->update([
                        'admin_status' => 'details_sent',
                        'customer_status' => 'review',
                    ]);

                    Notification::make()
                        ->success()
                        ->title('Rincian jasa dikirim!')
                        ->send();

                    $this->refreshFormData(['admin_status']);
                }),

            // Step 3: Upload Gantt
            Action::make('upload_gantt')
                ->label('📊 Upload Gantt')
                ->icon('heroicon-o-arrow-up-tray')
                ->color('info')
                ->visible(fn () => $status === 'details_sent' && $customerStatus === 'details_approved')
                ->form([
                    FileUpload::make('gantt_chart')
                        ->label('Gantt Chart')
                        ->directory('gantt_charts')
                        ->acceptedFileTypes(['application/pdf', 'image/jpeg', 'image/png'])
                        ->required(),
                    FileUpload::make('approval_file')
                        ->label('Lembar Persetujuan')
                        ->directory('approval_files')
                        ->acceptedFileTypes(['application/pdf', 'image/jpeg', 'image/png'])
                        ->required(),
                    TextInput::make('pic_contact')
                        ->label('PIC (Nama & Telepon)')
                        ->placeholder('Budi (081234567890)')
                        ->required(),
                ])
                ->action(function (array $data) {
                    $this->record->update([
                        'gantt_chart' => $data['gantt_chart'],
                        'approval_file' => $data['approval_file'],
                        'pic_contact' => $data['pic_contact'],
                        'admin_status' => 'gantt_uploaded',
                    ]);

                    Notification::make()
                        ->success()
                        ->title('Gantt chart dikirim!')
                        ->send();

                    $this->refreshFormData(['admin_status']);
                }),

            // Download gantt (proposal download moved into form as a preview link)
            Action::make('download_gantt')
                ->label('📊 Gantt')
                ->icon('heroicon-o-arrow-down-tray')
                ->visible(fn () => $this->record->gantt_chart)
                ->url(fn () => route('booking.downloadFile', ['booking' => $this->record->id, 'type' => 'gantt_chart']))
                ->openUrlInNewTab(),

            DeleteAction::make(),
        ];
    }
}
