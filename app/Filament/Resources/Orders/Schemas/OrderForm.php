<?php

namespace App\Filament\Resources\Orders\Schemas;

use App\Models\Product;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\ToggleColumn;
use function PHPUnit\Framework\callback;

class OrderForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([

                Toggle::make('status'),
                 

                Select::make('branch_id')
                    ->relationship('branch', 'location')
                    ->required(),



                Repeater::make('orderProducts')->label("Products")
                    ->schema([
                        Select::make('product_id')
                            ->options(Product::pluck('name', 'id'))
                            ->reactive()
                            ->afterStateUpdated(
                                fn($state, Set $set) =>
                                $set('price', Product::find($state)?->price)
                            )
                            ->required(),


                        TextInput::make('quantity')

                            ->numeric()
                            ->required(),

                        TextInput::make('price')
                         ->numeric()

                        // ->multiple() allow select multiple
                    ])
            ]);
    }
}
