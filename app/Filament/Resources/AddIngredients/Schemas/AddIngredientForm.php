<?php

namespace App\Filament\Resources\AddIngredients\Schemas;

use App\Models\Branch;
use App\Models\Ingredient;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class AddIngredientForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Repeater::make('AddIngredient')
                    ->label('Ingredient')
                    ->schema([
                        Select::make('ingredient_id')
                            ->label('Ingredient')
                            ->options(Ingredient::pluck('name', 'id'))
                            ->searchable()
                            ->required()
                            ->distinct()
                        // ->disableOptionsWhenSelectedInSiblingRepeaterItems()
                        ,
                        Select::make('branch_id')
                            ->label('Ingredient')
                            ->options(Branch::pluck('name', 'id'))
                            ->searchable()
                            ->required()
                            ->distinct() //make sure that only want can be select
                        ,


                        TextInput::make('quantity')
                            ->numeric()
                            ->required()
                            ->default(1)
                            ->minValue(0.01)
                            ->step(0.01),

                    ])
                    ->columns(3)
                    ->defaultItems(0)
                    ->addActionLabel('Add New Stock')
                    ->reorderable(false)
                    ->collapsible()
                    ->collapsed(false)
                    ->itemLabel(
                        fn(array $state): ?string =>
                        Ingredient::find($state['ingredient_id'] ?? null)?->name ?? 'New Stock'
                    ),
            ]);
    }
}
