<?php

namespace App\Filament\Sales\Resources\Orders\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Illuminate\Support\Facades\Auth;
use Filament\Forms\Components\Repeater;


class OrderForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Forms\Components\Hidden::make('sales_id')
                    ->default(fn () => Auth::guard('sales')->id()),
                TextInput::make('product_name')->required(),
                TextInput::make('quantity')
                    ->numeric()
                    ->required(),
                TextInput::make('price')
                    ->numeric()
                    ->required()
                    ->prefix('Rp'),
                // Repeater::make('images')
                //     ->schema([
                //         FileUpload::make('path')
                //             ->label('Upload Images')
                //             ->directory('orders')
                //             ->disk('public')
                //             ->visibility('public')
                //             ->image()
                //             ->downloadable(),
                //     ])
                //     ->columnSpanFull()
                FileUpload::make('images')
                    ->multiple()
                    ->label('Upload Images')
                    ->directory('orders')
                    ->disk('public')
                    ->visibility('public')
                    ->image()
                    ->downloadable()
                    ->columnSpanFull(),
            ]);
    }
}
