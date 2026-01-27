<?php

namespace App\Filament\Resources\Orders\RelationManagers;

use App\Models\Product;
use Filament\Actions\AttachAction;
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

class ProductOrderRelationManager extends RelationManager
{
    protected static string $relationship = 'products';  // ✅ CORRECT - matches the method name in Order model
    
    protected static ?string $recordTitleAttribute = 'name';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('product_id')
                    ->label('Product')
                    ->options(Product::pluck('name', 'id'))
                    ->required()
                    ->reactive()
                    ->afterStateUpdated(
                        fn($state, callable $set) =>
                        $set('price', Product::find($state)?->price)
                    ),

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
                    ->label('Product')
                    ->searchable()
                    ->sortable(),
                    
                TextColumn::make('pivot.quantity')
                    ->label('Quantity')
                    ->sortable(),
                    
                TextColumn::make('pivot.price')
                    ->label('Price')
                    ->money('PHP')
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
                        TextInput::make('price')
                            ->numeric()
                            ->required()
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
                        TextInput::make('price')
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