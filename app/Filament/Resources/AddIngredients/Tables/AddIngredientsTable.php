<?php

namespace App\Filament\Resources\AddIngredients\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class AddIngredientsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
               TextColumn::make('id')
                ,
                TextColumn::make('ingredients.name'),
                TextColumn::make('ingredients.quantity')
                ->label('QTY'),
                // TextColumn::make('ingredients.price')
                // ->label('PRIce'),

                
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
