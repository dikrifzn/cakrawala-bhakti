<?php

namespace App\Filament\Resources\Bookings\Pages;

use App\Filament\Resources\Bookings\BookingResource;
use App\Models\Booking;
use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\Concerns\InteractsWithRecord;
use Filament\Resources\Pages\Page;
use Illuminate\Support\Facades\Storage;

class ReviewBooking extends Page
{
    use InteractsWithRecord;

    protected static string $resource = BookingResource::class;

    protected static ?string $title = 'Review Booking';

    protected ?string $heading = 'Review Booking';

    protected string $view = 'filament.resources.bookings.pages.review-booking';

    public Booking $booking;

    public function mount($record): void
    {
        $this->record = $this->resolveRecord($record);
        // Eager load relations to avoid N+1 queries
        $this->record->load(['details', 'tasks', 'user']);
        $this->booking = $this->record;
    }

    protected function getHeaderActions(): array
    {
        $primary = [];

        switch ($this->record->admin_status) {
            case 'review':
                $primary = [
                    $this->makeSendDetailsAction(),
                    $this->makeEditDetailsAction(),
                    $this->makeEditTasksAction(),
                    $this->makeRejectAction(),
                ];
                break;
            case 'detail_sent':
                $primary = $this->record->customer_status === 'detail_approved'
                    ? [
                        $this->makeSendApprovalAction(),
                        $this->makeEditDetailsAction(),
                        $this->makeEditTasksAction(),
                    ]
                    : [
                        $this->makeEditDetailsAction(),
                        $this->makeEditTasksAction(),
                        $this->makeRejectAction(),
                    ];
                break;
            case 'final_approved':
                $primary = [
                    $this->makeUploadSignatureOfflineAction(),
                    $this->makeMarkOnProgressAction(),
                    $this->makeEditDetailsAction(),
                    $this->makeEditTasksAction(),
                ];
                break;
            case 'on_progress':
                $primary = [
                    $this->makeMarkFinishedAction(),
                    $this->makeEditTasksAction(),
                ];
                break;
            default:
                $primary = [
                    $this->makeEditDetailsAction(),
                    $this->makeEditTasksAction(),
                ];
        }

        $secondary = [
            $this->makeDownloadApprovalAction(),
            $this->makeRegenerateApprovalAction(),
            Action::make('edit')
                ->label('Edit Data')
                ->icon('heroicon-o-pencil-square')
                ->color('gray')
                ->url(fn () => BookingResource::getUrl('edit', ['record' => $this->record]))
                ->openUrlInNewTab(),
            DeleteAction::make(),
        ];

        return array_values(array_filter([
            ...$primary,
            ...$secondary,
        ]));
    }

    protected function makeSendDetailsAction(): Action
    {
        return Action::make('send_details')
            ->label('Kirim rincian ke client')
            ->icon('heroicon-o-paper-airplane')
            ->color('primary')
            ->visible(fn () => $this->record->admin_status === 'review')
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

                Repeater::make('tasks')
                    ->relationship('tasks')
                    ->label('Jadwal Pengerjaan')
                    ->schema([
                        TextInput::make('task_name')
                            ->label('Task')
                            ->required(),
                        DatePicker::make('start_date')
                            ->label('Mulai')
                            ->required(),
                        DatePicker::make('end_date')
                            ->label('Selesai')
                            ->required(),
                        TextInput::make('pic')
                            ->label('PIC')
                            ->placeholder('Nama / Kontak'),
                        TextInput::make('order')
                            ->label('Urutan')
                            ->numeric()
                            ->default(1),
                    ])
                    ->addActionLabel('+ Tambah Jadwal')
                    ->collapsible(),
            ])
            ->action(function () {
                $this->record->update([
                    'admin_status' => 'detail_sent',
                    'customer_status' => 'submitted',
                ]);

                // Notify customer
                if ($this->record->user) {
                    $this->record->user->notify(new \App\Notifications\BookingStatusUpdatedNotification(
                        $this->record,
                        'Detail layanan telah dikirimkan. Silakan cek dan berikan persetujuan.'
                    ));
                }

                Notification::make()
                    ->success()
                    ->title('Rincian jasa dikirim!')
                    ->send();

                $this->refreshBooking();
            });
    }

    protected function makeEditDetailsAction(): Action
    {
        return Action::make('edit_details')
            ->label('Edit rincian & harga')
            ->icon('heroicon-o-pencil')
            ->color('secondary')
            ->visible(fn () => in_array($this->record->admin_status, ['review', 'detail_sent', 'final_approved', 'on_progress']))
            ->fillForm(fn () => [
                'details' => $this->record->details->toArray(),
            ])
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
                Notification::make()
                    ->success()
                    ->title('Jasa dan harga berhasil diperbarui!')
                    ->send();

                $this->refreshBooking();
            });
    }

    protected function makeUploadSignatureOfflineAction(): Action
    {
        return Action::make('upload_signature_offline')
            ->label('Upload tanda tangan')
            ->icon('heroicon-o-pencil-square')
            ->color('success')
            ->visible(fn () => in_array($this->record->admin_status, ['final_approved']) && $this->record->approval_file && !$this->record->signature_file)
            ->form([
                \Filament\Forms\Components\FileUpload::make('signature_file')
                    ->label('File Tanda Tangan (Hasil Scan/Foto)')
                    ->disk('public')
                    ->directory('signature_files')
                    ->acceptedFileTypes(['image/png', 'image/jpeg', 'application/pdf'])
                    ->maxSize(5120)
                    ->helperText('Upload scan/foto TTD pada lembar persetujuan (PNG, JPG, atau PDF, max 5MB)')
                    ->required(),
            ])
            ->action(function (array $data) {
                $this->record->update([
                    'signature_file' => $data['signature_file'],
                    'customer_status' => 'final_signed',
                ]);

                // Notify customer
                if ($this->record->user) {
                    $this->record->user->notify(new \App\Notifications\BookingStatusUpdatedNotification(
                        $this->record,
                        'Tanda tangan Anda telah diterima. Booking Anda sekarang final_signed.'
                    ));
                }

                Notification::make()
                    ->success()
                    ->title('Tanda tangan berhasil diupload!')
                    ->send();

                $this->refreshBooking();
            });
    }

    protected function makeEditTasksAction(): Action
    {
        return Action::make('edit_tasks')
            ->label('Atur jadwal')
            ->icon('heroicon-o-calendar')
            ->color('success')
            ->visible(fn () => in_array($this->record->admin_status, ['review', 'detail_sent', 'final_approved', 'on_progress']))
            ->fillForm(fn () => [
                'tasks' => $this->record->tasks->toArray(),
            ])
            ->form([
                Repeater::make('tasks')
                    ->relationship('tasks')
                    ->label('Jadwal Pengerjaan')
                    ->schema([
                        TextInput::make('task_name')
                            ->label('Task')
                            ->required(),
                        DatePicker::make('start_date')
                            ->label('Mulai')
                            ->required(),
                        DatePicker::make('end_date')
                            ->label('Selesai')
                            ->required(),
                        TextInput::make('pic')
                            ->label('PIC')
                            ->placeholder('Nama / Kontak'),
                        TextInput::make('order')
                            ->label('Urutan')
                            ->numeric()
                            ->helperText('Untuk mengurutkan task'),
                    ])
                    ->minItems(1)
                    ->addActionLabel('+ Tambah Task')
                    ->collapsible(),
            ])
            ->action(function (array $data) {
                Notification::make()
                    ->success()
                    ->title('Jadwal pengerjaan berhasil diperbarui!')
                    ->send();

                $this->refreshBooking();
            });
    }

    protected function makeRegenerateApprovalAction(): Action
    {
        return Action::make('regenerate_approval')
            ->label('Buat ulang approval')
            ->icon('heroicon-o-arrow-path')
            ->color('gray')
            ->visible(fn () => in_array($this->record->admin_status, ['detail_sent', 'final_approved', 'on_progress', 'finished']) && !$this->record->approval_file)
            ->requiresConfirmation()
            ->action(function () {
                $pdfBinary = \App\Services\ApprovalService::generateApprovalPdf($this->record);

                $filename = 'approval_' . $this->record->id . '_' . now()->timestamp . '.pdf';
                $path = 'approval_files/' . $filename;

                Storage::disk('public')->put($path, $pdfBinary);

                $this->record->update([
                    'approval_file' => $path,
                ]);

                Notification::make()
                    ->success()
                    ->title('Lembar persetujuan berhasil dibuat ulang!')
                    ->send();

                $this->refreshBooking();
            });
    }

    protected function makeRejectAction(): Action
    {
        return Action::make('reject')
            ->label('Tolak booking')
            ->icon('heroicon-o-x-circle')
            ->color('danger')
            ->visible(fn () => in_array($this->record->admin_status, ['review', 'detail_sent']))
            ->requiresConfirmation()
            ->action(function () {
                $this->record->update([
                    'admin_status' => 'rejected',
                    'customer_status' => 'rejected',
                ]);

                // Notify customer
                if ($this->record->user) {
                    $this->record->user->notify(new \App\Notifications\BookingStatusUpdatedNotification(
                        $this->record,
                        'Booking Anda telah ditolak.'
                    ));
                }

                Notification::make()
                    ->success()
                    ->title('Booking ditolak')
                    ->send();

                $this->refreshBooking();
            });
    }

    protected function makeSendApprovalAction(): Action
    {
        return Action::make('send_approval')
            ->label('Kirim lembar persetujuan')
            ->icon('heroicon-o-document-text')
            ->color('primary')
            ->visible(fn () => $this->record->admin_status === 'detail_sent' && $this->record->customer_status === 'detail_approved')
            ->action(function () {
                $pdfBinary = \App\Services\ApprovalService::generateApprovalPdf($this->record);

                $filename = 'approval_' . $this->record->id . '_' . now()->timestamp . '.pdf';
                $path = 'approval_files/' . $filename;

                Storage::disk('public')->put($path, $pdfBinary);

                $this->record->update([
                    'approval_file' => $path,
                    'admin_status' => 'final_approved',
                ]);

                // Notify customer
                if ($this->record->user) {
                    $this->record->user->notify(new \App\Notifications\BookingStatusUpdatedNotification(
                        $this->record,
                        'Lembar persetujuan final telah siap. Silakan cek dan upload tanda tangan.'
                    ));
                }

                Notification::make()
                    ->success()
                    ->title('Lembar persetujuan dikirim ke client!')
                    ->send();

                $this->refreshBooking();
            });
    }

    protected function makeMarkOnProgressAction(): Action
    {
        return Action::make('mark_on_progress')
            ->label('Mulai pengerjaan')
            ->icon('heroicon-o-briefcase')
            ->color('info')
            ->visible(fn () => $this->record->admin_status === 'final_approved' && $this->record->customer_status === 'final_signed')
            ->action(function () {
                $this->record->update(['admin_status' => 'on_progress']);

                Notification::make()
                    ->success()
                    ->title('Status diubah ke On Progress')
                    ->send();

                $this->refreshBooking();
            });
    }

    protected function makeMarkFinishedAction(): Action
    {
        return Action::make('mark_finished')
            ->label('Tandai selesai')
            ->icon('heroicon-o-flag')
            ->color('success')
            ->visible(fn () => $this->record->admin_status === 'on_progress')
            ->requiresConfirmation()
            ->action(function () {
                $this->record->update(['admin_status' => 'finished']);

                Notification::make()
                    ->success()
                    ->title('Booking selesai!')
                    ->send();

                $this->refreshBooking();
            });
    }

    protected function makeDownloadApprovalAction(): Action
    {
        return Action::make('download_approval')
            ->label('📄 Approval')
            ->icon('heroicon-o-arrow-down-tray')
            ->visible(fn () => filled($this->record->approval_file))
            ->url(fn () => route('booking.downloadFile', ['booking' => $this->record->id, 'type' => 'approval_file']))
            ->openUrlInNewTab();
    }

    protected function refreshBooking(): void
    {
        $this->record->refresh();
        $this->booking = $this->record;
    }

    protected function getViewData(): array
    {
        return [
            'booking' => $this->booking,
        ];
    }
}
