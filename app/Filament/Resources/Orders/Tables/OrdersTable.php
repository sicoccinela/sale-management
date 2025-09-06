<?php

namespace App\Filament\Resources\Orders\Tables;

use Filament\Tables\Table;
use Filament\Actions\Action;
use Barryvdh\DomPDF\Facade\Pdf;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Illuminate\Support\Facades\Auth;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables;
use App\Models\Order;
use Filament\Actions\ActionGroup;
use Filament\Tables\Columns\BadgeColumn;

class OrdersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('sales.name')->label('Sales')->sortable(),
                TextColumn::make('product_name')->sortable(),
                TextColumn::make('quantity')->sortable(),
                TextColumn::make('price')
                    ->money('idr', true)
                    ->sortable(),
                TextColumn::make('total')
                    ->label('Total')
                    ->money('idr', true),
                TextColumn::make('status')
                    ->badge()      
                    ->color(fn(string $state): string => match($state){
                        'DIPROSES'=>'gray',
                        'DIVERIFIKASI'=>'warning',
                        'DIPRINT'=>'success',
                    })
            ])
            ->defaultSort('created_at', direction: 'desc')
            ->filters([
                //
            ])
            ->recordActions([
                ActionGroup::make([
                    ViewAction::make(),
                    EditAction::make(),
                    // Action::make('verify')
                    //     ->label('Verifikasi')
                    //     ->visible(fn (Order $record) => $record->status === 'DIPROSES')
                    //     ->action(fn (Order $record) => $record->update(['status' => 'DIVERIFIKASI'])),

                    // Action::make('printInvoice')
                    //     ->label('Print Invoice')
                    //     ->visible(fn (Order $record) => $record->status === 'DIVERIFIKASI')
                    //     ->url(fn (Order $record) => route('orders.print', $record))
                    //     ->openUrlInNewTab(),

                    Action::make('download')
                        ->label('Download Invoice')
                        ->color('success')
                        ->icon('heroicon-o-arrow-down-tray')
                        ->visible(fn (Order $record) => $record->status === 'DIPRINT')
                        ->url(fn (Order $record) => route('orders.download', $record)),
                    ])
                ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
