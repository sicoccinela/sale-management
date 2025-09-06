<?php

namespace App\Filament\Sales\Resources\Orders;

use App\Filament\Sales\Resources\Orders\Pages\CreateOrder;
use App\Filament\Sales\Resources\Orders\Pages\EditOrder;
use App\Filament\Sales\Resources\Orders\Pages\ListOrders;
use App\Filament\Sales\Resources\Orders\Pages\ViewOrder;
use App\Filament\Sales\Resources\Orders\Schemas\OrderForm;
use App\Filament\Sales\Resources\Orders\Schemas\OrderInfolist;
use App\Filament\Sales\Resources\Orders\Tables\OrdersTable;
use App\Models\Order;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;
    public static function getEloquentQuery(): Builder
    {
        $query = parent::getEloquentQuery();
        $salesId = auth('sales')->id();

        // Jika login di panel sales, filter berdasarkan sales_id
        if (filament()->getCurrentPanel()->getId() === 'sales') {
            $query->where('sales_id', $salesId);
        }

        return $query;
    }

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;
    public static function getNavigationBadge(): ?string
    {
        if (filament()->getCurrentPanel()->getId() === 'sales') {
        // Hitung order hanya untuk sales yang sedang login
        return static::getModel()::where('sales_id', auth('sales')->id())->count();
        }
        // Default: Admin lihat semua order
        return static::getModel()::count();
    }

    protected static ?string $navigationBadgeTooltip = 'The number of Orders';

    public static function form(Schema $schema): Schema
    {
        return OrderForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return OrderInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return OrdersTable::configure($table);
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
            'index' => ListOrders::route('/'),
            'create' => CreateOrder::route('/create'),
            'view' => ViewOrder::route('/{record}'),
            'edit' => EditOrder::route('/{record}/edit'),
        ];
    }
}
