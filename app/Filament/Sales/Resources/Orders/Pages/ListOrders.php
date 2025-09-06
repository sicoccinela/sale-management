<?php

namespace App\Filament\Sales\Resources\Orders\Pages;

use App\Filament\Sales\Resources\Orders\OrderResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;
use Filament\Schemas\Components\Tabs\Tab;
use App\Models\Order;

class ListOrders extends ListRecords
{
    protected static string $resource = OrderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->label('Ajukan Pesanan'),
        ];
    }

    public function getTabs(): array
    {
        $salesId = auth('sales')->id();
        return [
            'Semua' => Tab::make()
                ->modifyQueryUsing(fn (Builder $query) =>
                    $query->where('sales_id', $salesId)
                )
                ->badge(
                    Order::where('sales_id', $salesId)->count()
                ),

            'Diproses' => Tab::make()
                ->modifyQueryUsing(fn (Builder $query) =>
                    $query->where('status', 'DIPROSES')
                          ->where('sales_id', $salesId)
                )
                ->badge(
                    Order::where('status', 'DIPROSES')
                         ->where('sales_id', $salesId)
                         ->count()
                )
                ->badgeColor('warning'),

            'Diverifikasi' => Tab::make()
                ->modifyQueryUsing(fn (Builder $query) =>
                    $query->where('status', 'DIVERIFIKASI')
                          ->where('sales_id', $salesId)
                )
                ->badge(
                    Order::where('status', 'DIVERIFIKASI')
                         ->where('sales_id', $salesId)
                         ->count()
                )
                ->badgeColor('success'),

            'Diprint' => Tab::make()
                ->modifyQueryUsing(fn (Builder $query) =>
                    $query->where('status', 'DIPRINT')
                          ->where('sales_id', $salesId)
                )
                ->badge(
                    Order::where('status', 'DIPRINT')
                         ->where('sales_id', $salesId)
                         ->count()
                )
                ->badgeColor('success'),
        ];
    }
}
