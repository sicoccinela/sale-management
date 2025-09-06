<?php

namespace App\Filament\Resources\Orders\Pages;

use App\Filament\Resources\Orders\OrderResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;
use Filament\Actions\Action;
use App\Models\Order;

class EditOrder extends EditRecord
{
    protected static string $resource = OrderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
            Action::make('verify')
                ->label('Verifikasi')
                ->color('success')
                ->icon('heroicon-o-check')
                ->visible(fn (Order $record) => $record->status === 'DIPROSES')
                ->action(function (Order $record) {
                    $record->update([
                        'status' => 'DIVERIFIKASI',
                        'verified_by' => auth('web')->id(), // id admin yang login
                        'verified_at' => now(),
                    ]);
                    // if ($record->status !== 'DIVERIFIKASI') {
                    //     $record->update([
                    //         'status' => 'DIVERIFIKASI',
                    //         'verified_by' => auth('web')->id(),
                    //         'verified_at' => now(),
                    //     ]);
                    // }
                })
                // ->after(fn () => $this->redirect($this->getResource()::getUrl('edit', ['record' => $this->record->getKey()])))
                ->requiresConfirmation(),

            Action::make('resetVerification')
                ->label('Reset Verifikasi')
                ->color('danger')
                ->icon('heroicon-o-arrow-uturn-left')
                ->visible(fn (Order $record) => $record->status === 'DIVERIFIKASI')
                ->action(function (Order $record) {
                    $record->update([
                        'status' => 'DIPROSES',
                        'verified_by' => null,
                        'verified_at' => null,
                    ]);
                })
                ->requiresConfirmation(),
                
            // Tombol Print Invoice
            Action::make('printInvoice')
                ->label('Print Invoice')
                ->color('warning')
                ->icon('heroicon-o-printer')
                ->visible(fn (Order $record) => $record->status === 'DIVERIFIKASI')
                ->url(fn (Order $record) => route('orders.print', $record))
                ->openUrlInNewTab(),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
