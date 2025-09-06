<?php

namespace App\Filament\Resources\Orders\Pages;

use App\Filament\Resources\Orders\OrderResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use App\Models\Order;
use Illuminate\Database\Eloquent\Builder;
use Filament\Schemas\Components\Tabs\Tab;

class ListOrders extends ListRecords
{
    protected static string $resource = OrderResource::class;

    // protected function getHeaderActions(): array
    // {
    //     return [
    //         CreateAction::make(),
    //     ];
    // }

    public function getTabs(): array
    {
        return [
            'Semua' => Tab::make()
                ->badge(Order::count()),

            'Diproses' => Tab::make()
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', 'DIPROSES'))
                ->badge(Order::where('status', 'DIPROSES')->count())
                ->badgeColor('warning'),

            'Diverifikasi' => Tab::make()
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', 'DIVERIFIKASI'))
                ->badge(Order::where('status', 'DIVERIFIKASI')->count())
                ->badgeColor('success'),

            'Diprint' => Tab::make()
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', 'DIPRINT'))
                ->badge(Order::where('status', 'DIPRINT')->count())
                ->badgeColor('danger'),
        ];
    }
}
