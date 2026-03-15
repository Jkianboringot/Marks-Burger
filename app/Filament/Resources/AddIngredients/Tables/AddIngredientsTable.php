<?php

namespace App\Filament\Resources\AddIngredients\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class AddIngredientsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('ingredients.name'),
                TextColumn::make('ingredients.pivot.quantity')
                    ->label('QTY'),
              
                TextColumn::make('branch.location')

            ])
            ->filters([
                SelectFilter::make('branch_id')
                ->relationship('branch','location')
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make()

            ])
            ->toolbarActions([
                // BulkActionGroup::make([
                //     DeleteBulkAction::make(),
                // ]),
            ]);
    }
}
