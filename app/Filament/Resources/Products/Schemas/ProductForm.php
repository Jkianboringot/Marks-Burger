<?php

namespace App\Filament\Resources\Products\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class ProductForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                    TextInput::make('name'),
                    TextInput::make('price')->label('price')
                    ->numeric()->step(0.01)->minValue(0)->required(),
                    TextInput::make('description')
            ]);
    }
}
