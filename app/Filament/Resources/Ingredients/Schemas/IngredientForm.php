<?php

namespace App\Filament\Resources\Ingredients\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class IngredientForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required(),
                TextInput::make('threshold')
                    ->required()
                    ->numeric(),

                Select::make('category_id')
                    ->label('Category')
                    ->relationship('category', 'name'),
                TextInput::make('unit_quantity')
                    ->numeric(),
            ]);
    }
}
