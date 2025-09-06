<?php

namespace App\Filament\Sales\Resources\Orders\Tables;

use App\Models\Order;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Table;
use Filament\Actions\Action;
use Barryvdh\DomPDF\Facade\Pdf;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Support\Facades\Auth;

class OrdersTable
{
    protected static ?string $model = Order::class;
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
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
                    }),
                TextColumn::make('verifiedBy.name')
                    ->label('Verified by')
                    ->default('-'),
                TextColumn::make('verified_at')
                    ->label('Verified Time')
                    ->dateTime('d M Y H:i', 'Asia/Makassar'),
            ])
            ->defaultSort('created_at', direction: 'desc')
            ->filters([
                //
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make()
                    ->visible(fn() => auth()->guard('sales')->check())
                    ->hidden(fn (Order $record) => in_array($record->status, ['DIVERIFIKASI', 'DIPRINT'])),
                Action::make('download')
                    ->visible(fn (Order $record) => $record->status === 'DIPRINT')
                    ->label('Download Invoice')
                    ->color('primary')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->url(fn (Order $record) => route('orders.download', $record)),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
