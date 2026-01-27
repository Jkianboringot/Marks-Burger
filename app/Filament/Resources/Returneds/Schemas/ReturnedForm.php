<?php

namespace App\Filament\Resources\Returneds\Schemas;

use App\Models\Product;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class ReturnedForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('order_id')
                    ->relationship('order', 'id')
                    ->required(),
                Select::make('branch_id')
                    ->relationship('branch', 'location')
                    ->required(),

                Repeater::make('returnedProduct')
                    ->label('Products')
                    ->schema([
                        Select::make('product_id')
                            ->options(Product::pluck('name', 'id'))
                            ->reactive()
                            ->afterStateUpdated(fn($state, $set) =>
                            $set('price', Product::find($state)?->price)),


                        TextInput::make('quantity')
                            ->numeric()->required(),

                        TextInput::make('price')
                            ->numeric()
                    ])
            ]);
    }
}
