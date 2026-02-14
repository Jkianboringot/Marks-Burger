<?php

namespace App\Filament\Resources\Ingredients\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class IngredientsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->searchable(),
                TextColumn::make('threshold')
                    ->numeric()
                    ->sortable(),

                TextColumn::make('category.name')
                    ->sortable(),
                TextColumn::make('unit_quantity')
                    ->numeric()
                    ->sortable(),

                TextColumn::make('Stock')
                    // //will not work if its product_count needs to be prural
                    ->getStateUsing(function ($record) {
                        return $record->ingredient_stock

                            // dd($record->sold())
                        ;
                    })

                    ->label('Stock'), //  aliase name

                //                 TextColumn::make('Stock')
                //              
                //              ->getStateUsing(function ($record) {
                //     return $record->stock();
                // })
                // ok this work what we will do is create a  centralize stock not like that 
                //i have no idea how to decrease in it

                //                 ->label('Stock'), 






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
