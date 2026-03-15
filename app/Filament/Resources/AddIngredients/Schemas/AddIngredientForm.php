<?php

namespace App\Filament\Resources\AddIngredients\Schemas;

use App\Models\Branch;
use App\Models\Ingredient;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class AddIngredientForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(1)        // force the schema itself to single column
            ->components([

                // ── TOP: Branch selector ──────────────────────────────
                Section::make('Branch')
                    ->description('Select which branch will receive this stock.')
                    ->icon('heroicon-o-building-storefront')
                    ->columnSpanFull()  // stretch full width
                    ->schema([
                        Select::make('branch_id')
                            ->label('Branch Location')
                            ->options(Branch::pluck('location', 'id'))
                            ->searchable()
                            ->required()
                            ->distinct()
                            ->native(false)
                            ->placeholder('Select a branch…')
                            ->columnSpanFull(),
                    ]),

                // ── BOTTOM: Ingredients repeater ──────────────────────
                Section::make('Stock Items')
                    ->description('Add the ingredients and quantities for this delivery.')
                    ->icon('heroicon-o-beaker')
                    ->columnSpanFull()  // stretch full width
                    ->schema([
                        Repeater::make('AddIngredient')
                            ->label('')
                            ->schema([
                                Select::make('ingredient_id')
                                    ->label('Ingredient')
                                    ->options(Ingredient::pluck('name', 'id'))
                                    ->searchable()
                                    ->required()
                                    ->distinct()
                                    ->native(false)
                                    ->placeholder('Choose ingredient…'),

                                TextInput::make('quantity')
                                    ->label('Quantity')
                                    ->numeric()
                                    ->required()
                                    ->default(1)
                                    ->minValue(0.01)
                                    ->step(0.01)
                                    ->suffix('units'),
                            ])
                            ->columns(1)    // inside each card: stacked vertically
                            ->grid(2)       // cards displayed 2 per row
                            ->defaultItems(0)
                            ->addActionLabel('Add Ingredient')
                            ->reorderable(false)
                            ->collapsible()
                            ->collapsed(false)
                            ->itemLabel(
                                fn(array $state): ?string =>
                                Ingredient::find($state['ingredient_id'] ?? null)?->name ?? 'New Item'
                            ),
                    ]),

            ]);
    }
}