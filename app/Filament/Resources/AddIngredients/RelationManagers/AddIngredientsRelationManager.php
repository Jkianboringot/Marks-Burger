<?php

namespace App\Filament\Resources\AddIngredients\RelationManagers;

use App\Models\Ingredient;
use Filament\Actions\AttachAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\DetachAction;
use Filament\Actions\DetachBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class AddIngredientsRelationManager extends RelationManager
{
    protected static string $relationship = 'ingredients';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                  Select::make('ingredient_id')
                    ->label('Product')
                    ->options(Ingredient::pluck('name', 'id'))
                    ->required(),

                TextInput::make('quantity')
                    ->numeric()
                    ->required()
                    ->default(1)
                    ->minValue(0.01),

                TextInput::make('price')
                    ->numeric()
                    ->required()
                    ->minValue(0.01),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                TextColumn::make('name')
                    ->label('Ingredient')
                    ->searchable()
                    ->sortable(),
                    
                TextColumn::make('pivot.quantity')
                    ->label('Quantity')
                    ->sortable(),
                    
              
            ])
            ->filters([
                //
            ])
            ->headerActions([
                AttachAction::make()
                    ->preloadRecordSelect()
                    ->form(fn (AttachAction $action): array => [
                        $action->getRecordSelect(),
                        TextInput::make('quantity')
                            ->numeric()
                            ->required()
                            ->default(1)
                            ->minValue(0.01),
                       
                    ]),
            ])
            ->actions([
                EditAction::make()
                    ->form([
                        TextInput::make('quantity')
                            ->numeric()
                            ->required()
                            ->minValue(0.01),
                      
                    ]),
                DetachAction::make(),
            ])
            ->bulkActions([
                DeleteBulkAction::make(),
                DetachBulkAction::make(),
            ]);
    }
}
