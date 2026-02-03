<?php

namespace App\Filament\Resources\Ingredients\Schemas;

use App\Models\Branch;
use Filament\Forms\Components\Repeater;
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
                    ->numeric()
                    ->minValue(0.01)
                    ->step(0.01),

                Select::make('category_id')
                    ->label('Category')
                    ->relationship('category', 'name'),
                TextInput::make('unit_quantity')
                    ->required()
                    ->numeric()
                    ->minValue(0.01)
                    ->step(0.01),



            ]);
    }
}
